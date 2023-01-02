<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;

class EncodeResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);
        $data = $response->getData();
        if (isset($data->data)) {
            $data->data = $this->encrypt($data->data);
        };
        $response->setData($data);
        return $response;
    }

    private function encrypt($value, $serialize = true) {
        $iv = random_bytes(openssl_cipher_iv_length(strtolower('AES-256-CBC')));
        $key = Redis::get(explode(' ', request()->server->get('HTTP_AUTHORIZATION'))[1]) ?? config('app.key');

        $value = \openssl_encrypt(
            $serialize ? serialize($value) : $value,
            strtolower('AES-256-CBC'), $key, 0, $iv, $tag
        );

        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        $iv = base64_encode($iv);
        $tag = base64_encode($tag ?? '');

        $mac =  hash_hmac('sha256', $iv.$value, $key);
        $json = json_encode(compact('iv', 'value', 'mac', 'tag'), JSON_UNESCAPED_SLASHES);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return base64_encode($json);
    }
}

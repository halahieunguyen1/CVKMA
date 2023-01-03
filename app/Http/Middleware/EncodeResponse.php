<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Crypt;
use App\Libs\Crypt;
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
            $data->data = Crypt::encryptString(json_encode($data->data));
        };
        $response->setData($data);
        return $response;
    }
}

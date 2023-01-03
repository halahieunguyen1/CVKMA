<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Crypt;
use App\Libs\Crypt;
use Illuminate\Support\Facades\Redis;

class DecodeRequest
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
        $input = $request->input('encode', '');
        if ($input) {
            $data = json_decode(Crypt::decryptString($input));
            $request->offsetUnset('encode');
            $arr = [];
            foreach($data as $key => $item) {
                $arr[$key] = $item;
            }
            $request->merge($arr);
        }

        return $next($request);
    }
}

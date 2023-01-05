<?php

namespace App\Http\Middleware;

use App\Enums\Response\MessageEnum;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Crypt;
use App\Libs\Crypt;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheLockRegister
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
        // return $next($request);
        $email = $request->input('email');
        $timeLock = 30;
        $lock = Cache::lock(config('key_lock.prefix.lock_account_user') . $email, $timeLock);
        if (!$lock->get()) {
            return reponseError(statusCode: 404, message: MessageEnum::ACCOUNT_CREATING);

        }
        $response = $next($request);
        $lock->release();
        return $response;
    }
}

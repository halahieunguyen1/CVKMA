<?php


namespace App\Services;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Redis;

class CryptService
{
    public function storeKeyAES($token)
    {
        $key = $this->randomKeyAES();
        Redis::setex($token, env('JWT_TTL', 3600), $key);
        return $key;
    }
   
    public function randomKeyAES()
    {
        return base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );
    }
}

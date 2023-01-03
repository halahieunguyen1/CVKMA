<?php

namespace App\Libs;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Facades\Redis;

class Crypt
{
    public static function encryptString($value, $serialize = false) {
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

    public static function decryptString($payload, $unserialize = false)
    {
        $key = Redis::get(explode(' ', request()->server->get('HTTP_AUTHORIZATION'))[1]) ?? config('app.key');
        $payload = json_decode(base64_decode($payload), true);

        // If the payload is not valid JSON or does not have the proper keys set we will
        // assume it is invalid and bail out of the routine since we will not be able
        // to decrypt the given value. We'll also check the MAC for this encryption.
        if (! self::validPayload($payload)) {
            throw new DecryptException('The payload is invalid.');
        }

        if (! hash_equals(
            hash_hmac('sha256', $payload['iv'].$payload['value'], $key), $payload['mac']
        )) {
            throw new DecryptException('The MAC is invalid.');
        }


        $iv = base64_decode($payload['iv']);

        // Here we will decrypt the value. If we are able to successfully decrypt it
        // we will then unserialize it and return it out to the caller. If we are
        // unable to decrypt this value we will throw out an exception message.
        $decrypted = \openssl_decrypt(
            $payload['value'], strtolower('AES-256-CBC'), $key, 0, $iv, $tag ?? ''
        );

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $unserialize ? unserialize($decrypted) : $decrypted;
    }

    public static function validPayload($payload)
    {
        if (! is_array($payload)) {
            return false;
        }

        foreach (['iv', 'value', 'mac'] as $item) {
            if (! isset($payload[$item]) || ! is_string($payload[$item])) {
                return false;
            }
        }

        if (isset($payload['tag']) && ! is_string($payload['tag'])) {
            return false;
        }

        return strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length(strtolower('AES-256-CBC'));
    }
}
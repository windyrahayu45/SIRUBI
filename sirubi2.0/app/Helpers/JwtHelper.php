<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function generateToken($payload)
    {
        return JWT::encode(
            $payload,
            config('jwt.key'),
            config('jwt.algorithm')
        );
    }

    public static function decodeToken($token)
    {
        return JWT::decode(
            $token,
            new Key(config('jwt.key'), config('jwt.algorithm'))
        );
    }
}

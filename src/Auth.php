<?php
namespace App;
use Firebase\JWT\JWT;

class Auth 
{
/**
 * @OA\Get(path="/)
 * 
 * }
 */
    public static function authenticate(){
        $key = 'privatekey';
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            'iss' => 'http://liveapi.local/api',
            'aud' => 'http://livetest.local/',
            'iat' => $iat,
            'exp' => $exp,
        );
        $jwt = JWT::encode($payload, $key, 'HS512');
        return array(
            'token' => $jwt,
            'exp' => $exp
        );
    }
}

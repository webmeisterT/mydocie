<?php
namespace App;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;

class Auth 
{
    public static $secret_key = 'cf898c94e022ca956b6fd7a0d5ff588099776e96473763880ddbbef5214496b124d453b014d8477c7a86898f5682fd90ccc406b2c065961ad85d3b8bdb1af904';
    public static function authenticate(int $id, string $email){        
        $iat = new DateTimeImmutable();
        $exp = $iat->modify('+3600 minutes')->getTimestamp();
        $payload = [
            'iss' => 'http://127.0.0.1',
            'aud' => 'http://127.0.0.1',
            // 'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'id'=>$id,
                'email'=>$email
            ]
        ];
        $jwt = JWT::encode($payload, Auth::$secret_key, 'HS512');
        return $jwt;
    }

    public static function decodeAuth(array $allheaders){
        $jwt = str_replace('Bearer ', '', $allheaders['Authorization']);
        $decoded = JWT::decode($jwt, new Key(Auth::$secret_key, 'HS512'));
    
        $id = $decoded->data->id;
        return $id;
    }
}

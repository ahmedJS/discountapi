<?php
namespace MyDeps\Encryption;

use Firebase\JWT\JWT;

class Encrypt implements IEncrypt{

    function encode($payload , $key,$algorithm="HS256")
    {
        return JWT::encode($payload , $key,$algorithm);
    }

    /**
     * @return StdClass
     * @return void otherwise
     */
    function decode($token , $key , $allowed_alg=[])
    {
        return JWT::decode($token , $key , $allowed_alg);
    }
}
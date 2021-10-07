<?php
namespace MyDeps\JWT;

use MyDeps\JWT\IJWT;

use Firebase\JWT\JWT;

class JWT1 implements IJWT{

    function encode($payload , $key,$algorithm="HS256")
    {
        return JWT::encode($payload , $key,$algorithm);
    }

    function decode($token , $key , $allowed_alg=[])
    {
        return JWT::decode($token , $key , $allowed_alg);
    }
}
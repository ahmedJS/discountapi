<?php
use MyDeps\Encryption\Token;
use MyDeps\Encryption\Encrypt;

class TokenTest extends PHPUnit\Framework\TestCase{
    function testtoken(){
        $token = new Token(new Encrypt);

    }
    function testGenerateToken(){
        $enc = new Encrypt();

        $payload = [
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + (60 * 5),
            "content" => ["helo"]
        ];
        $enc->encode($payload,"key");
    }

    function testThrowException(){
        
    }
}
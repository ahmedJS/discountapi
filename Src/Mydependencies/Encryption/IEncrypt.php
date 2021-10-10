<?php
namespace MyDeps\Encryption;
interface IEncrypt {
    function encode($payload , $key,$algorithm="HS256");
    function decode($token , $key , $allowed_alg=[]);
}
<?php
namespace MyDeps\JWT;
interface IJWT {
    function encode($payload , $key,$algorithm="HS256");
    function decode($token , $key , $allowed_alg=[]);
}
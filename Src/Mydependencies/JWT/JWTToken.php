<?php 
namespace MyDeps\JWT;
use MyDeps\JWT\JWT1;

/**
 * it behave like a container of many properties such as 
 * $token , expired , $content
 * the first it injected throgh the object constructor and the rest will generated automatecly
 */
class JWTToken {
    protected $jwt_lib;
    private string $token;
    private bool $expired;
    private array $content;

    function __construct()
    {
        $this->jwt_lib = new JWT1;
    }

    function generateDetails($token,$key,$allowed_alg){
        $this->jwt_lib->decode($token , $key , $allowed_alg=[]);
    }
    
    /**
     * @return Array Containing content and expired of not
     */
    function GetDetails(){

    }
}
<?php
namespace Controllers;
use Firebase\JWT\JWT;

class QRCodeProvider{
    function __construct()
    {
        
    }

    function __invoke($req,$res,$args)
    {
        JWT::encode([
            "aud" => "name",
            "iat" => time(),
            "nbf" => time() + (60*60*60),
            "content" => ["userpasstoken"]
        ],"secretkey","HS256");
    }
}
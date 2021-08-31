<?php

namespace Controllers;
use Psr\Http\Message\ResponseInterface;

class Process extends \Controllers\Header{
    private $container;
    function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return ResponseInterface
     */
    function __invoke($req , $res, $args){
        $token = $args["data"];
        $jwt_lib = $this->container->JWT;

        if($token) {
            $jwt_lib::decode($token,);
        } else {
            
        }
    }
}
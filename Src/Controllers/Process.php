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
     * the head of token processing inserted by the uri
     * @return ResponseInterface
     */
    function __invoke($req , $res, $args){
        $token = $args["data"];
        if($token = $this->container->QR->check_valid_jwt_token($token))
        {
            // here processing with database
        }
    }


}
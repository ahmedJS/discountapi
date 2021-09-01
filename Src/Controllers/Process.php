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
        if($token = $this->check_valid_jwt_token($token))
        {
            // here processing with database
        }
    }

    /**
     * @return array of decoded token on success
     * @return false when token not valid
     * @param string $token the token need to validation
     */
    function check_valid_jwt_token($token){
        $jwt_lib = $this->container->JWT;
        if($token) {
            // make sure if it valid token or not as well as decode it
            $details = $jwt_lib::decode($token,$this->get_jwt_key(),"HS256");
                if($details)
                {
                    return $details;
                }  
        }
        return false;
    }
}
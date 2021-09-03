<?php
namespace Controllers;


use Psr\Http\Message\ResponseInterface;

use Controllers\Header;

class QRCodeProvider extends Header{
    private $container;
    
    function __construct(\Interop\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * invoke function that deployed when class used as a function 
     * and it is considered as start point 
     * clinet function of generation route
     * intent here is generate a url QR that when scan and locate , it will used once and nuactivated
     * e.i http://www.discountapi/process/token it will return done or unactivated
     * @return ResponseInterface
     */
    function __invoke($req,$res,$args)
    {
        $ratue = $args["ratue"];

        $db = $this->DataBase;
        
        $query = $db->query("insert into discount_items(discount_ratue,iat,nbf,active_state)values(?,?,?,?)",[
            $ratue,
            time(),
            time() + (60*60),
            "active"
        ]);

        $id = $db->get_last_id(); 
        
        // if the request 1 it mean active
        // if the request 0 it mean unactive
        $data_to_encoded = [
            "request" =>  self::QRCODEPROVIDER_UNACTIVE,
            "id" => $id
        ];

        // encode data and convert into token
        $data = $this->QR->jwt_encoder("HS256",$this->secret,$data_to_encoded);

        // generate a QR CODE
        // and return the response object with body contains the png echoed
        $qr = $this->QR->qr_generate("http://www.discountapi/process/".$data,"mypic.png");

        // insert it into response returned
        $res->getBody()->write($qr["qrcode"]);
        return $res->withHeader("Content-Type",$qr["mimetype"]);
    }

}
<?php
namespace Controllers;


use Psr\Http\Message\ResponseInterface;
use Entities\DiscountItems;
use Controllers\Header;
use DateTime;

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

        // need validation
        $ratue = $args["ratue"];
        
        if(1){

            // obtain the doctrine entityManager
            $em = $this->container->em;
            
            $discount_entity = new DiscountItems;

            // generate random tokens
            $token = $this->randomTokensGenerate();

            // set the entity information
            $discount_entity->setActive_state("active")
                ->setDiscount_ratue($ratue)
                ->setIat(new DateTime())
                ->setNbf(new DateTime("now +1 minute"))
                ->setToken($token);

            $data_to_encoded = ["token" =>  $token];
            // make sure this record is inserted into database as well
            if(1){
                $em->persist($discount_entity);
                $em->flush();
            }
            // encode data and convert into token
            $data = $this->container->QR->jwt_encoder("HS256",$this->get_jwt_key(),$data_to_encoded);

            // generate a QR CODE
            $qr = $this->container->QR->qr_generate("http://www.discountapi/process/".$data,"mypic.png");

            // insert it into response returned
            $res->getBody()->write($qr["qrcode"]);

            // and return the response object with body contains the png echoed
            return $res->withHeader("Content-Type",$qr["mimetype"]);
        }


    }

    function randomTokensGenerate(){
        return md5(uniqid());
    }
    
    

}
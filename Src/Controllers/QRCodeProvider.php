<?php
namespace Controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRCodeProvider{
    function __construct()
    {
        
    }

    /**
     * invoke function that deployed when class used as a function 
     * and it is considered as start point
     * @return ResponseInterface
     */

    function __invoke($req,$res,$args)
    {
        $data_to_encoded = ["somthing"];
        $data = $this->jwt_encoder("HS256","psd12123434",$data_to_encoded);

        // generate a QR CODE
        $this->qr_generate($data,"mypic.png");
    }

    function qr_generate($data_included,$path){
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $writer->writeFile($data_included, $path);        
    }


    function jwt_encoder(string $algorithm,string $secret_key,Array $content):string {
        $var = JWT::encode([
            "aud" => "name",
            "iat" => time(),
            "nbf" => time() + (60*60*60),
            "content" => $content
        ],$secret_key,$algorithm);

        return $var;
    }
}
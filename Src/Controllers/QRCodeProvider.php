<?php
namespace Controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

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
        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($data_included)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText('This is the label')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();

        $result->saveToFile("png.png");
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
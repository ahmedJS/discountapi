<?php

namespace MyDeps\QRUtility;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

use Firebase\JWT\JWT;
class QR{

    /**
     * this function make qr code as well as return it as string and its mime type
     * @return array an associative array containing "qrcode" and "mimetype"
     * @param string $data_included the data that needed to the qr code included
     * @param string $path string that specify the directory and name of the qr code image file
     */
    function qr_generate($data_included,$path = null)
    {

        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($data_included)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText('discount item')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();

        switch ($path):
                case null :
                // do nothing
            break;
                default :
                $result->saveToFile($path);
            break;
        endswitch;
        
        return ["qrcode" => $result->getString(),
                "mimetype" => $result->getMimeType()
        ];
    }


    /**
     * @return string jwt token of provided data
     */
    function jwt_encoder(string $algorithm,string $secret_key,Array $content)
    {
        $jwt_lib = new JWT;
        $var = $jwt_lib::encode([
            "aud" => "name",
            "iat" => time(),
            "nbf" => time() + (60*60*60),
            "content" => $content
        ],$secret_key,$algorithm);

        return $var;
    }

    /**
     * @return mixed of decoded token on success
     * @return bool false when token not valid
     * @param string $token the token need to validation
     */
    function check_valid_jwt_token($token,$secret_key,$algorithm = "HS256"){
        $jwt_lib = $this->container->JWT;
        if($token) {
            // make sure if it valid token or not as well as decode it
            $details = $jwt_lib::decode($token,$secret_key,$algorithm);
                if($details)
                {
                    return $details;
                }  
        }
        return false;
    }
}
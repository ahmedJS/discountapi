<?php
namespace Controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use MyDeps\Database\DataBase;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeProvider{
    const QRCODEPROVIDER_UNACTIVE = 0;
    private $secret = "psd12123434";
    function __construct($container)
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

        $db = new Database();
        
        $query = $db->query("insert into discount_items(discount_ratue,iat,nbf,active_state)values(?,?,?,?)",[
            $ratue,
            time(),
            time() + (60*60),
            "active"
        ]);

        $id = $db->get_last_id(); 
        
        $data_to_encoded = [
            "request" =>  self::QRCODEPROVIDER_UNACTIVE,
            "id" => $id
        ];

        // encode data and convert into token
        $data = $this->jwt_encoder("HS256",$this->secret,$data_to_encoded);

        // generate a QR CODE
        // and return the response object with body contains the png echoed
        $qr = $this->qr_generate("http://www.discountapi/process/".$data,"mypic.png");

        // insert it into response returned
        $res->getBody()->write($qr["qrcode"]);
        return $res->withHeader("Content-Type",$qr["mimetype"]);
    }


    /**
     * this function make qr code as well as return it as string and its mime type
     * @return array an associative array containing "qrcode" and "mimetype"
     * @param string $data_included the data that needed to the qr code included
     * @param string $path string that specify the directory and name of the qr code image file
     */
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
        ->labelText('discount item')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();

        $result->saveToFile($path);
        
        return ["qrcode" => $result->getString()
                ,"mimetype" => $result->getMimeType()
        ];
    }


    /**
     * @return string jwt token of provided data
     */
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
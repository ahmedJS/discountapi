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
    const MK_QR_READED = 0;
    private $secret = "psd12123434";
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
        $db = new Database();
        $query = $db->query("insert into discount_items(discount_ratue,iat,nbf,active_state)values(?,?,?,?)",[
            50,
            time(),
            time() + (60*60),
            "active"
        ]);

        $id = $db->get_last_id();
        var_dump($query->errorInfo());

        $data_to_encoded = [
            "request" =>  self::MK_QR_READED,
            "id" => $id
        ];
        $data = $this->jwt_encoder("HS256",$this->secret,$data_to_encoded);

        // generate a QR CODE
        $this->qr_generate("http://www.discountapi/process/".$data,"mypic.png");
    }


    /**
     * @return array an associative array containing qr code and mime type
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
        ->labelText('This is the label')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->build();

        $result->saveToFile($path);
        
        return ["qrcode" => $result->getString()
                ,"mimetype" => $result->getMimeType()
        ];
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
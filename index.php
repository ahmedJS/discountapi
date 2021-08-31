<?php
use Slim\App as myapp;
use Controllers\QRCodeProvider;
use Controllers\Process;
use Firebase\JWT\JWT;

require_once "vendor/autoload.php";

$myapp = new myapp([
    "settings"=>[
        "displayErrorDetails" => true
    ]
]);

$container = $myapp->getContainer();
$container["JWT"] = function(){return new JWT;};

$myapp->get("/generate/{ratue}",new QRCodeProvider($container));

$myapp->get("/process/[{data}]",new Process($container));

$myapp->run();



/*
    QR request scheme http://www.discountapi/process/".$data
*/
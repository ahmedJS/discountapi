<?php
use Slim\App as myapp;
use Controllers\QRCodeProvider;
use Controllers\Process;
use Firebase\JWT\JWT;
use MyDeps\Database\DataBase;
use MyDeps\QRUtility\QR;

require_once "vendor/autoload.php";

// obtaining doctrine orm
require_once "bootstrap.php";

$myapp = new myapp([
    "settings"=>[
        "displayErrorDetails" => true
    ]
]);

$container = $myapp->getContainer();

$container["JWT"] = function(){return new JWT;};
$container["QR"] = function(){return new QR;};

//inject entity manager
$container["em"] = function() use($entityManager) {return $entityManager;};

$myapp->get("/generate/{ratue}",new QRCodeProvider($container));

$myapp->get("/process/[{data}]",new Process($container));

$myapp->run();



/*
    QR request scheme http://www.discountapi/process/".$data
*/
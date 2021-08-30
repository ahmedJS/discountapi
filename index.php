<?php
use Controllers\QRCodeProvider;
use Slim\App as myapp;

require_once "vendor/autoload.php";

$myapp = new myapp([
    "settings"=>[
        "displayErrorDetails" => true
    ]
]);

$container = $myapp->getContainer();

$myapp->get("/generate/{ratue}",new QRCodeProvider($container));

$myapp->get("/process/");
$myapp->run();
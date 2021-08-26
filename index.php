<?php
use Controllers\QRCodeProvider;
use Slim\App as myapp;

require_once "vendor/autoload.php";

$myapp = new myapp([
    "settings"=>[
        "displayErrorDetails" => true
    ]
]);

$myapp->get("/",new QRCodeProvider);

$myapp->run();
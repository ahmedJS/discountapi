<?php
use Slim\App as myapp;
require_once "vendor/autoload.php";

$myapp = new myapp([
    "settings"=>[
        "displayErrorDetails" => true
    ]
]);


$myapp->run();
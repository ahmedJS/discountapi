<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$config = Setup::createAnnotationMetadataConfiguration(array("Src/Entities"),false,null,null,false);

$conn = DriverManager::getConnection(["url" => "mysql://root:root@localhost:3305/mydb"]);

$entityManager = EntityManager::create($conn,$config);

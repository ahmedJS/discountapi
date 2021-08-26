<?php
namespace MyApp\Mydependencies\Database;

use PDO;

class DataBase
{
    private PDO $mycon;
    private $query;
    function __construct()
    {
        $dsn = "mysql:dbname='discountapi'";
        $user= "root";
        $pass= "root";
        $this->mycon = new PDO($dsn,$user,$pass);
    }

    function query($query,Array $params)
    {
        $myquery = $this->mycon->prepare($query);
        $myquery->execute($params);
        $this->query = $myquery;
    }
}



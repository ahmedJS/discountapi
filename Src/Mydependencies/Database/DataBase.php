<?php
namespace MyDeps\Database;

use PDO;

class DataBase
{
    private  $mycon;
    private $query;
    function __construct()
    {
        $dsn = "mysql:host=localhost;port=3305;dbname='mydb'";
        $user= "root";
        $pass= "root";
        $option = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $this->mycon = new PDO($dsn,$user,$pass,$option);
    }

    function query($query,Array $params)
    {
        $myquery = $this->mycon->prepare($query);
        $myquery->execute($params);
        $this->query = $myquery;
    }
}



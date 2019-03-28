<?php

namespace App\Core;

use App\Interfaces\PersistenceInterface;

class DB implements PersistenceInterface
{
    public static $instance;
    private $pdoConn;

    private function __construct()
    {
        try
        {
            $this->pdoConn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
            $this->pdoConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e)
        {
           die($e->getMessage());
        }
    }

    public static function init()
    {

    }

    public function read()
    {

    }

    public function insert()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function count()
    {

    }
}

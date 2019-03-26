<?php

namespace App\Core;

use App\Interfaces\PersistenceInterface;

class DB implements PersistenceInterface
{
    public static $instance;

    private function __construct()
    {

    }

    public static function init()
    {

        if (!isset(self::$instance))
        {
            self::$instance = new DB();

        }
        return self::$instance;
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
}

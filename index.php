<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));

//include (ROOT. DS . 'core'. DS . 'config.php');


$url = isset( $_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

var_dump( getcwd() );
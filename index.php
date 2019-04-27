<?php


use Core\Router;


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');
include_once(ROOT . DS . 'core' . DS . 'config.php');


$url = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

Router::route($url);
<?php

use Core\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

include_once(ROOT. DS . 'core'. DS . 'config.php');

function autoload($className)
{
    $classNameWithNamespaceArray = explode('\\', $className);
    $classFile = array_pop($classNameWithNamespaceArray).'.php';

    foreach(ROUTES as $route)
    {
        $route = ROOT .DS.str_replace('/', DS, $route). $classFile;
        if (file_exists($route))
        {
            include_once($route);
            break;
        }
    }
}

spl_autoload_register('autoload');

$url = isset( $_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

Router::route($url);
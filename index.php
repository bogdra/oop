<?php

use App\Core\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

include_once(ROOT. DS . 'core'. DS . 'config.php');

function autoload($className)
{
    $classNameWithNamespaceArray = explode('\\', $className);
    $classFile = array_pop($classNameWithNamespaceArray).'.php';

    if (file_exists(ROOT. DS. 'interfaces'. DS. $classFile)){
        include_once(ROOT. DS. 'interfaces'. DS. $classFile);
    } elseif (file_exists(ROOT. DS. 'core'. DS. $classFile)) {
        include_once(ROOT. DS. 'core'. DS. $classFile);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'controllers'. DS. $classFile)) {
        include_once(ROOT. DS. 'app'. DS. 'controllers'. DS. $classFile);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'models'. DS. $classFile)) {
        include_once(ROOT. DS. 'app'. DS. 'models'. DS. $classFile);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'entities'. DS. $classFile)) {
        include_once(ROOT. DS. 'app'. DS. 'entities'. DS. $classFile);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'services'. DS. $classFile)) {
        include_once(ROOT . DS . 'app' . DS . 'services' . DS . $classFile);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'exceptions'. DS. $classFile)) {
        include_once(ROOT . DS . 'app' . DS . 'exceptions' . DS . $classFile);
    }
}

spl_autoload_register('autoload');

$url = isset( $_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

Router::route($url);
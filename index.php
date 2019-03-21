<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

include_once(ROOT. DS . 'core'. DS . 'config.php');
//include_once(ROOT. DS . 'core'. DS . 'Router.php');


function autoload($className)
{
    $className = basename($className);
    if (file_exists(ROOT. DS. 'intrefaces'. DS. $className. '.php')){
        include_once(ROOT. DS. 'interfaces'. DS. $className. '.php');
    } elseif (file_exists(ROOT. DS. 'core'. DS. $className. '.php')) {
        include_once(ROOT. DS. 'core'. DS. $className. '.php');
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'controllers'. DS. $className. '.php')) {
        include_once(ROOT. DS. 'app'. DS. 'controllers'. DS. $className. '.php');
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'models'. DS. $className. '.php')) {
        include_once(ROOT. DS. 'app'. DS. 'models'. DS. $className. '.php');
    }

}

spl_autoload_register('autoload');

$url = isset( $_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

$test = \Core\Router::route($url);
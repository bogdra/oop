<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

include_once(ROOT. DS . 'core'. DS . 'config.php');

function autoload($className)
{
    if (file_exists(ROOT. DS. 'intrefaces'. DS. $className)){
        include_once(ROOT. DS. 'interfaces'. DS. $className);
    } elseif (file_exists(ROOT. DS. 'core'. $className)) {
        include_once(ROOT. DS. 'interfaces'. DS. $className);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'controllers'. DS. $className)) {
        include_once(ROOT. DS. 'app'. DS. 'controllers'. DS. $className);
    } elseif (file_exists(ROOT. DS. 'app'. DS. 'models'. DS. $className)) {
        include_once(ROOT. DS. 'app'. DS. 'models'. DS. $className);
    }

}

spl_autoload_register('autoload');

$url = isset( $_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

\Core\Router::route($url);
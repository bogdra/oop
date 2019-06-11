<?php


use Core\Router;
use App\Exceptions\HeadersAlreadySentException;


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');
include_once(ROOT . DS . 'core' . DS . 'config.php');

try {
    $url = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];
    Router::route($url);
} catch (HeadersAlreadySentException $e) {
    echo $e;
}

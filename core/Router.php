<?php

namespace App\Core;

class Router
{
    private static  $controller,
                    $action;

    public static function route(array $urlElements)
    {
      $tempController = (isset($urlElements[0]) && $urlElements[0]!='') ? \ucfirst($urlElements[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
      self::$controller = 'App\Controller\\'.$tempController;

      self::$action  = (isset($urlElements[1]) && $urlElements[1]!='') ? \ucfirst($urlElements[1]).'Action' : DEFAULT_ACTION.'Action';

      //TODO trebuie rescris mai elegant
       if (\count($urlElements) > 2) {
           for ($i = 1; $i < \count($urlElements);$i++) {
               if ($urlElements[$i] != '') {
                   $params[] = $urlElements[$i];
               }
           }
       } else {
           $params = [];
       }

        (self::checkControllerAndActionExists()) ?
            call_user_func_array([new self::$controller, 'indexAction'], $params):
            self::redirect('Restricted/' );
    }

     public static function checkControllerAndActionExists()
     {
        if (class_exists(self::$controller) ) {
            $tempObject = new self::$controller;
            if (method_exists($tempObject, self::$action)) {
                return true;
            }
            unset ($tempObject);
        }
        return false;
    }

    public static function redirect(string $location, int $status = 301)
    {
        if(!headers_sent()) {
            http_response_code($status);
            header('Location: '.URL_ROOT.$location);
            exit();
        }
        die('Header allready sent. Killed execution');
    }


}

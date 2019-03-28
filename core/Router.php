<?php

namespace App\Core;

class Router
{
    private static  $controller,
                    $action;

    /**
     * Router method to call the right conntroller / action
     *
     * @param array $urlElements
     */
    public static function route(array $urlElements)
    {
          $tempController = (isset($urlElements[0]) && $urlElements[0]!='') ? \ucfirst($urlElements[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
          self::$controller = 'App\Controller\\'.$tempController;

         
          self::$action  = (isset($urlElements[1]) && $urlElements[1]!='') ? \lcfirst($urlElements[1]).'Action' : DEFAULT_ACTION.'Action';

          //TODO: needs rewrite
           if (\count($urlElements) > 2) {
               for ($i = 2; $i < \count($urlElements);$i++)
               {
                   if ($urlElements[$i] != '') {
                       $params[] = $urlElements[$i];
                   }
               }
           } else {
               $params = [];
           }

            (self::checkControllerAndActionExists()) ?
                call_user_func_array([new self::$controller, self::$action], $params):
                self::redirect('Restricted/' );
    }

    /**
     * Checks if the controller file exists and if so if the action required exists
     *
     * @return bool
     */
     public static function checkControllerAndActionExists()
     {
            if (class_exists(self::$controller) )
            {
                $tempObject = new self::$controller;
                if (method_exists($tempObject, self::$action))
                {
                    return true;
                }
                unset ($tempObject);
            }
            return false;
    }

    /**
     * Redirect the user to a specific page
     *
     * @param string $location
     * @param int $status
     */
    public static function redirect(string $location, $status = 301)
    {
            if(!headers_sent())
            {
                http_response_code($status);
                header('Location: '.URL_ROOT.$location);
                exit();
            }
            die('Header already sent. Killed execution');
    }


}

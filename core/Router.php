<?php

namespace App\Core;

class Router
{
    public static function route(array $urlElements)
    {

      $controller = (isset($urlElements[0]) && $urlElements[0]!='') ? \ucfirst($urlElements[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
      $controller = 'App\Controller\\'.$controller;

      $action  = (isset($urlElements[0]) && $urlElements[0]!='') ? \ucfirst($urlElements[0]).'Action' : DEFAULT_ACTION.'Action';


      //params
       if (\count($urlElements) > 2) {
           for ($i=1; $i<count($urlElements);$i++) {
               if ($urlElements[$i] != '') {
                   $params[] = $urlElements[$i];
               }
           }
       } else {
           $params = [];
       }

        \call_user_func_array([$controller, $action], $params);


    }
}

<?php
namespace Core;

class Router
{
    public static function route(array $url)
    {

      $controller = (isset($url[0]) && $url[0]!='') ? ucfirst($url[0]).'Controller' : DEFAULT_CONTROLLER.'Controller';
      $action  = (isset($url[1]) && $url[1]!='') ? ucfirst($url[1]).'Action' : DEFAULT_ACTION.'Action';


      //params
       if (count($url) > 2) {
           for ($i=1; $i<count($url);$i++) {
               if ($url[$i] != '') {
                   $params[] = $url[$i];
               }
           }
       }

        var_dump($controller.'/'.$action);
    }
}

echo ('test');
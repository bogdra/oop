<?php
namespace App\Core;

class Controller
{
    public      $view;
    protected   $controller,
                $action;

    public function __construct()
    {
        //$this->controller   = $controller;
        //$this->action       = $action;
        $this->view         = new \App\Core\View();
    }

    public function allowedRequestMethods($methods = [])
    {
        $availableMethods = ['GET','POST','PUT','DELETE'];

        foreach ($methods as $method) {
            if (!in_array(strtoupper($method), $availableMethods))
            {
                throw new \Exception('The selected request method is not valid');
            }
            if ($_SERVER['REQUEST_METHOD'] != $method)
            {
                die('The request method used is not supported');
            }
        }
    }


}
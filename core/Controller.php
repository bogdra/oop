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


}
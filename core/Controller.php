<?php


namespace App\Controllers;


use \Core\View;
use \App\Exceptions\Request\InvalidRequestMethodException;
use \App\Exceptions\Request\RequestMethodNotAllowedException;


class Controller
{
    public $view;


    public function __construct()
    {
        $this->view = new View();
    }


    public function allowedRequestMethods(string $allowedMethod)
    {       $requestMethodUsed =  $_SERVER['REQUEST_METHOD'];
            if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS)) {
                throw new InvalidRequestMethodException('The selected request method is not valid');

            } elseif ($requestMethodUsed != $allowedMethod) {
                throw new RequestMethodNotAllowedException
                ('The request method ' . $requestMethodUsed . ' is not supported for this route');
            }
    }
}

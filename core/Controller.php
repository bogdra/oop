<?php


namespace App\Controllers;


use \Core\View;
use \App\Exceptions\Request\InvalidRequestMethodException;
use \App\Exceptions\Request\RequestMethodNotAllowedException;


class Controller
{
    public $view;
    public $requestMethodUsed;


    public function __construct()
    {
        $this->view = new View();
        $this->requestMethodUsed = $_SERVER['REQUEST_METHOD'];
    }


    public function allowedRequestMethods(string $allowedMethod)
    {
            if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS)) {
                throw new InvalidRequestMethodException('The selected request method is not valid');

            } elseif ($this->requestMethodUsed != $allowedMethod) {
                throw new RequestMethodNotAllowedException
                ('The request method ' . $this->requestMethodUsed . ' is not supported for this route');
            }
    }
}

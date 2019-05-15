<?php


namespace App\Controllers;


use \Core\View;
use \App\Exceptions\InvalidRequestMethodException;
use \App\Exceptions\RequestMethodNotAllowedException;



class Controller
{
    public $view;
    public $requestMethodUsed;
    protected $logger;


    public function __construct()
    {
        $this->view = new View();
        $this->requestMethodUsed = $_SERVER['REQUEST_METHOD'];
    }


    public function allowedRequestMethods($allowedMethods = [])
    {
        foreach ($allowedMethods as $allowedMethod) {
            if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS)) {
                throw new InvalidRequestMethodException('The selected request method is not valid');
                break;
            } elseif ($this->requestMethodUsed != $allowedMethod) {
                throw new RequestMethodNotAllowedException
                ('The request method ' . $this->requestMethodUsed . ' is not supported for this route');
            }
        }
    }
}

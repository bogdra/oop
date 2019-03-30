<?php
namespace App\Controller;

use \App\Core\View;
use App\Exception\RequestException;

class Controller
{
    public $view;
    public $requestMethodUsed;


    public function __construct()
    {
        $this->view = new View();
        $this->requestMethodUsed = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Checks that the request method used is in the allowed of requests
     *
     * @param array $allowedMethods
     * @throws \App\Exception\RequestException
     */
    public function allowedRequestMethods($allowedMethods = [])
    {
        foreach ($allowedMethods as $allowedMethod)
        {
            if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS))
            {
                throw new RequestException('The selected request method is not valid');
                break;
            }
            elseif ($this->requestMethodUsed != $allowedMethod)
            {
                throw new RequestException('The request method '.$this->requestMethodUsed.' is not supported for this route');
            }


        }
    }

}

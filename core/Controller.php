<?php
namespace App\Controller;

use \App\Core\View;
use \App\Core\Router;

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
     * @throws \Exception
     */
    public function allowedRequestMethods($allowedMethods = []) :void
    {
        foreach ($allowedMethods as $allowedMethod) {
            try
            {
                if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS))
                {
                    throw new \Exception('The selected request method is not valid');
                    break;
                }
                elseif ($this->requestMethodUsed != $allowedMethod)
                {
                    throw new \Exception('The request method '.$this->requestMethodUsed.' is not supported for this route');
                }
            }
            catch (\Exception $e)
            {
                \App\Core\H::dnd($e->getMessage());
            }
        }
    }

}

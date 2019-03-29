<?php
namespace App\Controller;

use \App\Core\View;

class Controller
{
    public $view;
    public $currentRequestMethod;


    public function __construct()
    {
        $this->view = new View();
        $this->currentRequestMethod = $_SERVER['REQUEST_METHOD'];
    }


    public function allowedRequestMethods($allowedMethods = [])
    {
        foreach ($allowedMethods as $allowedMethod) {
            try
            {
                if (!\in_array(\strtoupper($allowedMethod), SUPPORTED_REQUEST_METHODS))
                {
                    throw new \Exception('The selected request method is not valid');
                    break;
                }
                elseif ($this->currentRequestMethod != $allowedMethod)
                {
                    throw new \Exception('The request method '.$this->currentRequestMethod.' is not supported for this route');
                }
            }
            catch (\Exception $e)
            {
                \Core\H::dnd($e);
            }


        }
    }


}
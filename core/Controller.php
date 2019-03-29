<?php
namespace App\Core;

class Controller
{
    public $view;
    public $currentRequestMethod = $_SERVER['REQUEST_METHOD'];

    public function __construct()
    {
        $this->view = new \App\Core\View();
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
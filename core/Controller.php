<?php
namespace App\Core;

class Controller
{
    public      $view;

    public function __construct()
    {
        $this->view         = new \App\Core\View();
    }

    /**
     * Checks that the request method used is in the allowed array of requests
     *
     * @param array $methods
     * @throws \Exception
     */
    protected function allowedRequestMethods($methods = [])
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
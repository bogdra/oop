<?php
namespace App\Controller;

use \Core\View;
use \App\Exception\RequestException;
use \App\Exception\ViewException;
use \App\Exception\StatusCodeException;

class Controller
{
    public $view;
    public $requestMethodUsed;


    public function __construct()
    {
        try
        {
            $this->view = new View();
        }
        catch (ViewException $e)
        {
            echo $e->getMessage();
        }
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
                throw new RequestException('The request method '.$this->requestMethodUsed.'
                                            is not supported for this route');
            }


        }
    }

    public function jsonResponse(array $data, int $status = 200, $message = '')
    {

        if (!in_array($status, [200, 301, 302, 404, 500]))
        {
            throw new StatusCodeException('The provided Status code '.$status.' is not supported');
        }

        if (!headers_sent())
        {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code($status);
            return \json_encode([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]);
        }

        throw new \Exception('The headers have already been sent');
    }

}

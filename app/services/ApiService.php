<?php


namespace App\Services;


use App\Interfaces\ApiResponseInterface;


class ApiService
{
    private $response;


    public function setResponse(ApiResponseInterface $response)
    {
        $this->response = $response;

        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);
            echo $this->response;
        }
        return 'Headers already sent';

    }


    public function getResponse()
    {
        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);
            echo $this->response;
        }
        return 'Headers already sent';

    }


}

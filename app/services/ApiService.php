<?php


namespace App\Services;


use App\Interfaces\ApiResponseInterface;


class ApiService
{
    private $response;


    public function setResponse(ApiResponseInterface $response): void
    {
        $this->response = $response;
    }


    public function getResponse()
    {
        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);

            return $this->response;
        }
        return 'Headers already sent';

    }


}
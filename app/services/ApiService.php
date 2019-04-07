<?php
namespace App\Services;

use App\Exception\StatusCodeException;
use App\Exception\RequestException;
use App\Entities\ApiResponseEntity;

class ApiService
{
    private $response;

    public function __construct()
    {
    }

    public function setResponse($message, int $statusCode = 200)
    {
        $this->response = new ApiResponseEntity($message, $statusCode);
    }

    public function jsonResponse()
    {
        if (!headers_sent())
        {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");

            \http_response_code($this->response->getResponseCode());

            return json_encode([
                'status' => 'OK',
                'message' => $this->response->getMessage()
            ]);
        }
        return 'Headers already sent';
    }



}
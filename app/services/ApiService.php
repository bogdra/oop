<?php

namespace App\Services;

use App\Entities\ApiResponseEntity;
use App\Interfaces\ApiResponseInterface;

class ApiService
{
    private $response;

    public function __construct($status, $data)
    {
        $this->response = new ApiResponseEntity($status, $data);
    }

    public function jsonResponse(): string
    {
        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);

            return json_encode($this->response->getResponse());
        }
        return 'Headers already sent';
    }

    private function getResponse(): ApiResponseInterface
    {
        return $this->response->getResponse();

    }


}
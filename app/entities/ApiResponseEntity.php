<?php
namespace App\Entities;

class ApiResponseEntity
{
    private $responseCode;
    private $message;

    public function __construct($message = '', $responseCode = 200)
    {
        $this->message = $message;
        $this->responseCode = $responseCode;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }
}
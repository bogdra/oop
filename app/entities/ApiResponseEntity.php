<?php

namespace App\Entities;

class ApiResponseEntity
{
    private $status;
    private $message;
    private $data;

    public function __construct($status, $data = '', $message = '')
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }
}
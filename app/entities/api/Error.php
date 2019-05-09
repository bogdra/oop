<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Error implements ApiResponseInterface
{
    private $message;
    private $status = 'error';

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function __toString()
    {
        return json_encode(
            [
                'status' => $this->status,
                'message' => $this->message
            ]
        );
    }
}
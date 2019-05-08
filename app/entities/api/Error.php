<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Error implements ApiResponseInterface
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }


    public function getResponse()
    {
        return json_encode(
            [
                'status' => substr(get_class($this), strrpos(get_class($this), '\\') + 1),
                'message' => $this->message
            ]
        );
    }
}
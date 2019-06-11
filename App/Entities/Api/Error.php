<?php


namespace App\Entities;


use App\Interfaces\ApiResponseAbstract;


class Error extends ApiResponseAbstract
{
    private $message;
    private $status = 'error';


    public function __construct($message)
    {
        $this->message = $message;
    }


    public function __toString()
    {
        $this->sendHeaders();
        return json_encode(
            [
                'status' => $this->status,
                'message' => $this->message
            ]
        );
    }
}
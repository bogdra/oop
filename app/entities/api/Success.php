<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Success implements ApiResponseInterface
{

    private $data;


    public function __construct($data)
    {
        $this->data = $data;
    }


    public function getResponse()
    {
        return json_encode(
            [
                'status' => \get_class($this),
                'data' => $this->data
            ]
        );
    }
}
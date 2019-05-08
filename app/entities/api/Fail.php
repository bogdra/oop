<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Fail implements ApiResponseInterface
{
    private $data;


    public function __construct(string $data)
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
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
                'status' => substr(get_class($this), strrpos(get_class($this), '\\') + 1),
                'data' => $this->data
            ]
        );
    }
}
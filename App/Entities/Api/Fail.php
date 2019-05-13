<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Fail implements ApiResponseInterface
{
    private $data;
    private $status = 'fail';


    public function __construct($data)
    {
        $this->data = $data;
    }


    public function __toString()
    {
        return json_encode(
            [
                'status' => $this->status,
                'data' => $this->data
            ]
        );
    }
}
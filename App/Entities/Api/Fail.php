<?php


namespace App\Entities;


use App\Interfaces\ApiResponseAbstract;


class Fail extends ApiResponseAbstract
{
    private $data;
    private $status = 'fail';


    public function __construct($data)
    {
        $this->data = $data;
    }


    public function __toString()
    {
        $this->sendHeaders();
        return json_encode(
            [
                'status' => $this->status,
                'data' => $this->data
            ]
        );
    }
}
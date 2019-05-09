<?php


namespace App\Entities;


use App\Interfaces\ApiResponseInterface;


class Success implements ApiResponseInterface
{
    private $data;
    private $status = 'success';


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

//    public function getJsonResponse()
//    {
//        return json_encode(
//            [
//                'status' => $this->status,
//                'data' => $this->data
//            ]
//        );
//    }
}
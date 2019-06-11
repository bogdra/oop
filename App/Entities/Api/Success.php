<?php


namespace App\Entities;


use App\Interfaces\ApiResponseAbstract;


class Success extends ApiResponseAbstract
{
    private $data;
    private $status = 'success';


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
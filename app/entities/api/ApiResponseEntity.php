<?php


namespace App\Entities;


use \App\Interfaces\ApiResponseInterface;


class ApiResponseEntity
{
    private $status;
    private $data;


    public function __construct($status, $dataOrMessage)
    {
        $this->status = $status;
        $this->data = $dataOrMessage;
    }


    public function getResponse(): ApiResponseInterface
    {
        switch (\strtolower($this->status)) {
            case 'success':
                return new Success($this->data);
            case 'fail':
                return new Fail($this->data);
            case 'error':
                return new Error($this->data);
            default:
                throw new \Exception('The status code is not recognised.');
        }
    }
}
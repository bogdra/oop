<?php


namespace App\Interfaces;


interface ApiResponseInterface
{
    /**
     * ApiResponseInterface constructor.
     * @param $data array | string
     */
    public function __construct($data);

    public function __toString();
}
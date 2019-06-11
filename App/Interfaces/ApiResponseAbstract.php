<?php


namespace App\Interfaces;


abstract class ApiResponseAbstract
{
    abstract public function __construct($data);

    abstract public function __toString();

    protected function sendHeaders()
    {
        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);
        } else {
            exit ('Headers already sent');
        }
    }
}

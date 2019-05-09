<?php


namespace App\Interfaces;


interface ApiResponseInterface
{
    public function __construct(string $data);
    public function __toString();
}
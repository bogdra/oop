<?php

namespace App\Model;

class ExchangeModel extends \App\Core\Model
{
    private $inputData;

    public $date;

    public function __construct()
    {
        parent::__construct();
        $this->setCurrencyRate();
    }

    private function convertXmlToObj(string $source)
    {
        return simplexml_load_string($source);
    }

    public function getCurrencyRate()
    {
        return $this->inputData;
    }

    private function setCurrencyRate()
    {
        $xmlRawInput = file_get_contents(INPUT_SOURCE);
        $this->inputData = $this->convertXmlToObj($xmlRawInput);
    }

    public function setDate()
    {
       // $this->date = $this->inputData->Cube->Cube->@attributes['time'];
    }

    public function test()
    {
        return $this->inputData->Cube->Cube;
    }
}
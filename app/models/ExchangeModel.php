<?php

namespace App\Model;

class ExchangeModel extends \App\Core\Model
{
    private $inputData;
    public  $date,
            $exchangesArray;

    public function __construct()
    {
        parent::__construct();
        $this->setCurrencyRate();
        $this->setDate();
        $this->setCurrencyRatesArray();
    }

    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }

    public function getCurrencyRate() :\SimpleXMLElement
    {
        return $this->inputData;
    }

    private function setCurrencyRate() :void
    {
        $xmlRawInput = file_get_contents(INPUT_SOURCE) or die('Could not retrieve the file');
        $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }

    public function setDate() :void
    {
        $this->date = (string)($this->inputData->attributes()['time']);
    }

    public function getDate() :string
    {
        return $this->date;
    }

    public function test()
    {
        return $this->inputData;
    }

    public function setCurrencyRatesArray() :void
    {
        $test = [];
        foreach ($this->inputData->children() as $currency_parity)
        {
          $test[(string)$currency_parity->attributes()['currency']] = (float)$currency_parity->attributes()['rate'];
        }
        $this->exchangesArray = $test;
    }

    public function getCurrencyRatesArray() :array
    {
        return $this->exchangesArray;
    }

}
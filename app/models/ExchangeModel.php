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

    private function setCurrencyRate()
    {
        $xmlRawInput = file_get_contents(INPUT_SOURCE) or die('Could not retrieve the file');
        $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }

    /**
     * setter of the Date from the currency object
     */
    private function setDate()
    {
        $this->date = (string)($this->inputData->attributes()['time']);
    }

    /**
     * getter function of the date
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setCurrencyRatesArray()
    {
        foreach ($this->inputData->children() as $currency_parity)
        {
          $test[(string)$currency_parity->attributes()['currency']] = (float)$currency_parity->attributes()['rate'];
        }
        $this->exchangesArray = $test;
    }

    public function getCurrencyRatesArray()
    {
        return $this->exchangesArray;
    }

}
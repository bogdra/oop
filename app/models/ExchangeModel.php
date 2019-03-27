<?php

namespace App\Model;

use mysql_xdevapi\Exception;

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


    private function getCurrencyCodes()
    {
        return array_keys($this->exchangesArray);
    }


    public function convertTo(string $currencyCode)
    {
        if ($currencyCode == 'EUR')
        {
            return $this->exchangesArray;
        }

        if (!in_array($currencyCode, $this->getCurrencyCodes()))
        {
            throw new \Exception('The selected currency is not supported');
        }

        $baseConversionRate = $this->exchangesArray[strtoupper($currencyCode)];

        foreach ($this->exchangesArray as $exchangeCod => $exchangeValue)
        {
            if ($exchangeCod != $currencyCode)
            {
                $newConversionArray[$exchangeCod] = round ($this->exchangesArray[$exchangeCod] / $baseConversionRate, 2);
            }
            else
            {
                $newConversionArray['EUR'] = round( 1 / $this->exchangesArray[$currencyCode], 2);
            }
        }
        return $newConversionArray;



    }

}
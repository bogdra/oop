<?php
namespace App\Services;

use App\Entities\currencyEntity;

class CurrencyService
{

    private $inputData;
    private $exchangeRatesArrayOfObjects;

    public function __construct()
    {
        $this->setCurrencyRateObj(INPUT_SOURCE);
        $this->setExchangeRatesObjectsArray();
    }


    private function setCurrencyRateObj($source)
    {

      $xmlRawInput =  file_get_contents($source) ;
        if (!$xmlRawInput){
            throw new \Exception('The file does not exists');
        }
        $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }


    public function getCurrencyRateObj() :\SimpleXMLElement
    {
        return $this->inputData;
    }


    public function setExchangeRatesObjectsArray()
    {
        foreach ($this->inputData->children() as $currency_parity)
        {
            $tempArray[] = new currencyEntity(
                'EUR',
                $currency_parity->attributes()['currency'],
                (float)$currency_parity->attributes()['rate']
            );
        }
        $this->exchangeRatesArrayOfObjects = $tempArray;

    }


    public function getExchangeRatesObjectsArray()
    {
        return $this->exchangeRatesArrayOfObjects;
    }


    public function getCurrencyRatesKeys()
    {
        foreach ($this->getExchangeRatesObjectsArray() as $obj)
        {
            $codes[] = $obj->currencyTo;
        }
        \array_unshift($codes, "EUR");

        return $codes;
    }


    public function getBaseConversionRate(string $currencyCode) :float
    {
        foreach ($this->exchangeRatesArrayOfObjects as $obj)
        {
            if ($obj->currencyTo == $currencyCode)
            {
                return $obj->rate;
            }
        }
        return 1;
    }


    public function convertTo(string $currencyCode)
    {
        if ($currencyCode == 'EUR')
        {
            return $this->getExchangeRatesObjectsArray();
        }

        $baseConversionRate = $this->getBaseConversionRate($currencyCode);

        foreach ($this->getExchangeRatesObjectsArray() as $exchangeCodeObj)
        {
            if ($exchangeCodeObj->currencyTo != $currencyCode)
            {
                $rate = round ($exchangeCodeObj->rate / $baseConversionRate, 2);
                $returnArray[] = new currencyEntity($currencyCode, $exchangeCodeObj->currencyTo, $rate);
            }
            else
            {
                $rate = round( 1 / $exchangeCodeObj->rate, 2);
                $returnArray[] = new currencyEntity($exchangeCodeObj->currencyTo,'EUR', $rate);
            }
        }
        return $returnArray;
    }


    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }
}
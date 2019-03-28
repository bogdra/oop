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


//    public function getCurrencyRatesKeys()
//    {
//        $codes = \array_keys($this->exchangeRatesArray);
//        \array_unshift($codes, "EUR");
//
//        return $codes;
//    }

    public function getBaseConversionRate(string $currencyCode)
    {
        foreach ($this->exchangeRatesArrayOfObjects as $obj)
        {
            print_r($obj);
            if ($obj->currencyFrom == $currencyCode)
            {
                return $obj->rate;
            }
           // return NULL;
        }
    }

    public function convertTo(string $currencyCode)
    {
        if ($currencyCode == 'EUR')
        {
            return $this->getExchangeRatesObjectsArray();
        }


        $baseConversionRate = $this->exchangeRatesArrayOfObjects[$currencyCode];
        \Core\H::dnd($baseConversionRate);

        foreach ($this->getExchangeRatesObjectsArray() as $exchangeCodeFromArray => $exchangeValue)
        {
            if ($exchangeCodeFromArray != $currencyCode)
            {
                $rate = round ($this->exchangeRatesArray[$exchangeCodeFromArray] / $baseConversionRate, 2);
                $returnArray[] = new currencyEntity($currencyCode, $exchangeCodeFromArray, $rate);
            }
            else
            {
                $rate = round( 1 / $this->exchangeRatesArray[$currencyCode], 2);
                $returnArray[] = new currencyEntity('EUR', $exchangeCodeFromArray, $rate);
            }
        }

        return $returnArray;
    }


    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }
}
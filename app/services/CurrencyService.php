<?php
namespace App\Services;

use App\Entities\currencyEntity;

class CurrencyService
{

    private $inputData;
    private $exchangeRatesArrayOfObjects;

    public function __construct()
    {
        $this->setBaseCurrencyObj(INPUT_SOURCE);
        $this->setEurExchangeRatesObjectsArray();
    }


    private function setBaseCurrencyObj(string $source)
    {
          $xmlRawInput =  file_get_contents($source) ;
          try
          {
              if (!$xmlRawInput){
                  throw new \Exception('The file does not exists');
              }
          }
          catch (\Exception $e)
          {
              echo $e->getMessage();
          }
          $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }


    public function getCurrencyRateObj() :\SimpleXMLElement
    {
        return $this->inputData;
    }


    public function setEurExchangeRatesObjectsArray()
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


    public function getEurExchangeRatesObjectsArray() :array
    {
        return $this->exchangeRatesArrayOfObjects;
    }


    public function getExchangeRatesKeys() :array
    {
        foreach ($this->getEurExchangeRatesObjectsArray() as $currencyObj)
        {
            $codes[] = $currencyObj->currencyTo;
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


    public function convertTo(string $currencyCode) :array
    {
        if ($currencyCode == 'EUR')
        {
            return $this->getEurExchangeRatesObjectsArray();
        }

        try
        {
            if (!in_array($currencyCode, $this->getExchangeRatesKeys()))
            {
                throw new \Exception('The currency code '.$currencyCode .' is not supported');
            }
        }
        catch(\Exception $e)
        {
            print_r($e->getMessage());
        }

        $baseConversionRate = $this->getBaseConversionRate($currencyCode);

        foreach ($this->getEurExchangeRatesObjectsArray() as $exchangeCodeObj)
        {
            if ($exchangeCodeObj->currencyTo != $currencyCode)
            {
                $rate = round ($exchangeCodeObj->rate / $baseConversionRate, 2);
                $returnArray[] = new currencyEntity(
                    $currencyCode,
                    $exchangeCodeObj->currencyTo,
                    $rate
                );
            }
            else
            {
                $rate = round( 1 / $exchangeCodeObj->rate, 2);
                $returnArray[] = new currencyEntity(
                    $exchangeCodeObj->currencyTo,
                    'EUR',
                    $rate
                );
            }
        }
        return $returnArray;
    }


    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }
}
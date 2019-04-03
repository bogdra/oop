<?php
namespace App\Services;

use App\Entities\CurrencyEntity;
use App\Exception\FileException;
use App\Exception\CurrencyException;
use Core\H;

class CurrencyService
{
    private $inputData;
    private $exchangeRatesArrayOfObjects;

    public function __construct()
    {
        $this->exchangeRatesArrayOfObjects = [];
        $this->setBaseCurrencyObj(INPUT_SOURCE);
        $this->setEurExchangeRatesObjectsArray();
    }

    private function setBaseCurrencyObj(string $source)
    {

        if (!H::remoteFileExists($source))
        {
            throw new FileException('The file does not exists');
        }
         $xmlRawInput = file_get_contents($source);
         $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }


    public function getCurrencyRateObj() :\SimpleXMLElement
    {
        return $this->inputData;
    }


    public function setEurExchangeRatesObjectsArray()
    {
       // H::dnd($this->inputData);
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
        $codes = [];
        foreach ($this->getEurExchangeRatesObjectsArray() as $currencyObj)
        {
            $codes[] = $currencyObj->getCurrencyTo();
        }
        \array_unshift($codes, "EUR");

        return $codes;
    }


    public function getBaseConversionRate(string $currencyCode) :float
    {
        foreach ($this->exchangeRatesArrayOfObjects as $obj)
        {
            if ($obj->getCurrencyTo() == $currencyCode)
            {
                return $obj->getRate();
            }
        }
        return 1;
    }


    public function convertTo(string $currencyCode) :array
    {
        if (!in_array($currencyCode, $this->getExchangeRatesKeys()))
        {
            throw new CurrencyException('The currency code '.$currencyCode .' is not supported');
        }
        if ($currencyCode == 'EUR')
        {
            return $this->getEurExchangeRatesObjectsArray();
        }

        $baseConversionRate = $this->getBaseConversionRate($currencyCode);

        foreach ($this->getEurExchangeRatesObjectsArray() as $exchangeCodeObj)
        {
            if ($exchangeCodeObj->getCurrencyTo() != $currencyCode)
            {
                $rate = round ($exchangeCodeObj->getRate() / $baseConversionRate, 2);
                $returnArray[] = new currencyEntity(
                    $currencyCode,
                    $exchangeCodeObj->getCurrencyTo(),
                    $rate
                );
            }
            else
            {
                $rate = round( 1 / $exchangeCodeObj->getRate(), 2);
                $returnArray[] = new currencyEntity(
                    $exchangeCodeObj->getCurrencyTo(),
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
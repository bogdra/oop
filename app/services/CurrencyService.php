<?php
namespace App\Services;

use App\Entities\CurrencyEntity;
use App\Exception\FileException;
use App\Exception\CurrencyException;
use Core\H;

class CurrencyService
{
    public  $currency;
    private $EurExchangeRatesArrayOfObjects;
    private $exchangeRateKeys;
    public  $currencyObj;


    public function __construct($currency = 'EUR')
    {
        $this->currency = $currency;
        $this->setEurExchangeRatesObjectsArray(INPUT_SOURCE);
        $this->setExchangeRatesKeys();
        $this->checkCurrencyCodeInArrayOfAvailableCurrencies($currency);

        $this->currencyObj = $this->convertTo($this->currency);
    }


    private function checkCurrencyCodeInArrayOfAvailableCurrencies(string $currency)
    {
        if (!in_array($currency, $this->getExchangeRatesKeys()))
        {
            throw new CurrencyException('the given Currency is not present in the array currencies');
        }
        return true;
    }


    private function setEurExchangeRatesObjectsArray($source)
    {
        if (!H::remoteFileExists($source))
        {
            throw new FileException('The Exchange currency file does not exists');
        }
        $xmlRawInput = file_get_contents($source);

        foreach ($this->convertXmlToObj($xmlRawInput)->Cube->Cube->children() as $currency_parity)
        {
            $tempArray[] = new currencyEntity(
                'EUR',
                $currency_parity->attributes()['currency'],
                (float)$currency_parity->attributes()['rate']
            );
        };
        $this->EurExchangeRatesArrayOfObjects = $tempArray;
    }


    public function getEurExchangeRatesObjectsArray()
    {
        return $this->EurExchangeRatesArrayOfObjects;
    }


    private function setExchangeRatesKeys()
    {
        $codes = [];
        foreach ($this->getEurExchangeRatesObjectsArray() as $currencyObj)
        {
            $codes[] = $currencyObj->getCurrencyTo();
        }
        \array_unshift($codes, "EUR");
        $this->exchangeRateKeys = $codes;
    }


    public function getExchangeRatesKeys()
    {
        return $this->exchangeRateKeys;
    }


    public function getBaseConversionRate(string $currencyCode) :float
    {
        foreach ($this->EurExchangeRatesArrayOfObjects as $obj)
        {
            if ($obj->getCurrencyTo() == $currencyCode)
            {
                return $obj->getRate();
            }
        }
        return 1;
    }


    public function convertTo(string $currencyCode)
    {
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


    public function toArray() :array
    {
        $arrayOfArrays = [];
        foreach ($this->currencyObj as $obj)
        {
            $tempCurrencyArray['currencyFrom'] = $obj->getCurrencyFrom();
            $tempCurrencyArray['currencyTo'] = $obj->getCurrencyTo();
            $tempCurrencyArray['rate'] = $obj->getRate();
            $arrayOfArrays[] = $tempCurrencyArray;
        }
        return $arrayOfArrays;
    }


    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }
}

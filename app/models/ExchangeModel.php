<?php

namespace App\Model;

class ExchangeModel extends \App\Core\Model
{
    private $inputData,
            $exchangeRatesArray;

    public function __construct()
    {
        parent::__construct();
        $this->setCurrencyRateObj(INPUT_SOURCE);
        $this->setExchangeRatesArray();
    }

    /**
     * Setter method for the inputData property. sets the property to an array of objects
     *
     * @param $source ExchangeModel The remote file used as a source
     */
    private function setCurrencyRateObj($source)
    {
        $xmlRawInput =  file_get_contents($source) ?: die('Could not retrieve the file');
        $this->inputData = $this->convertXmlToObj($xmlRawInput)->Cube->Cube;
    }

    /**
     * Getter method that returns the Xml object
     * @return \SimpleXMLElement
     */
    public function getCurrencyRateObj() :\SimpleXMLElement
    {
        return $this->inputData;
    }

    /**
     * converts the currency array of Objects into an array of strings
     */
    public function setExchangeRatesArray()
    {

        if ($this->inputData->count() == 0)
        {
            die('The currencies array is empty');
        }

        foreach ($this->inputData->children() as $currency_parity)
        {
          $tempArray[(string)$currency_parity->attributes()['currency']] = (float)$currency_parity->attributes()['rate'];
        }
        $this->exchangeRatesArray = $tempArray;
    }

    /**
     * Getter method for the exchange parities array
     * @return array The array with elements of this format "EUR" => 1.44
     */
    public function getExchangeRatesArray()
    {
        return $this->exchangeRatesArray;
    }

    /**
     * Getter method for the exchange rate keys
     * @return array Contains all the keys of the exchange parity [0=>"EUR", 1=>"USD"...
     */
    public function getCurrencyRatesKeys()
    {
        $codes = \array_keys($this->exchangeRatesArray);
        \array_unshift($codes, "EUR");

        return $codes;
    }

    /**
     * Converts the currencies to a specific currency
     *
     * @param string $currencyCode  The currency code to witch we want to change
     * @return array $newConversionArray all the others currencies values in relationship with $currencyCode received
     * @throws \Exception If the requested currency code does not exists
     */
    public function convertTo(string $currencyCode)
    {
        if ($currencyCode == 'EUR')
        {
            return $this->exchangeRatesArray;
        }

        if (!in_array($currencyCode, $this->getCurrencyRatesKeys()))
        {
            throw new \Exception('The selected currency is not supported');
        }

        $baseConversionRate = $this->exchangeRatesArray[strtoupper($currencyCode)];

        foreach ($this->exchangeRatesArray as $exchangeCod => $exchangeValue)
        {
            if ($exchangeCod != $currencyCode)
            {
                $newConversionArray[$exchangeCod] = round ($this->exchangeRatesArray[$exchangeCod] / $baseConversionRate, 2);
            }
            else
            {
                $newConversionArray['EUR'] = round( 1 / $this->exchangeRatesArray[$currencyCode], 2);
            }
        }

        return $newConversionArray;
    }

    /**
     * Converts a xml raw input into a xml object
     *
     * @param string $source
     * @return \SimpleXMLElement
     */
    private function convertXmlToObj(string $source) :\SimpleXMLElement
    {
        return new \SimpleXMLElement($source);
    }

}
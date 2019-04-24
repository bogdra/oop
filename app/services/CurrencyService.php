<?php

namespace App\Services;

use App\Entities\Currency;
use App\Entities\CurrencyExchanger;
use App\Entities\EurExchangeRate;
use App\Exception\FileException;
use App\Exception\CurrencyException;
use Core\Helper;

class CurrencyService
{
    public $currency;
    public $currencyObj;
    private $eurExchangeRates;


    public function __construct(ECBCurrencyExchange $ECBCurrencyExchange)
    {
        $this->eurExchangeRates = $ECBCurrencyExchange->getEurRates();
    }


    private function canExchange(Currency $currency): void
    {
        if (!$this->eurExchangeRates->hasCurrencyRate($currency)) {
            throw new CurrencyException('the given Currency is not present in the array currencies');
        }
    }


    public function getExchangeRate(Currency $fromCurrency, Currency $toCurrency): float
    {

        try {
            foreach ([$toCurrency, $fromCurrency] as $currency) {
                $this->canExchange($currency);
            }
            $fromCurrencyToEURRate = 1 / $this->eurExchangeRates->getRateForCurrency(new Currency($fromCurrency));
            $forCurrencyRate = $this->eurExchangeRates->getRateForCurrency(new Currency($toCurrency));

        } catch (CurrencyException $currencyException) {
            echo $currencyException->getMessage();
        }


        return round($fromCurrencyToEURRate * $forCurrencyRate, 2);
    }


    public function getExchangeRatesForSpecificCurrency(Currency $currency): array
    {
        $rates = [];
        foreach ($this->eurExchangeRates->getSupportedCurrenciesCodes() as $item) {

            if ($item->__toString() == $currency->__toString()) {
                continue;
            }
            $parity = new \stdClass;
            $parity->currencyTo = $item->__toString();
            $parity->rate = $this->getExchangeRate($currency, new Currency($item));

            $rates[] = (object)$parity;
        }
        return $rates;
    }


    public function getSupportedCurrencies()
    {
        return $this->eurExchangeRates->getSupportedCurrenciesCodes();
    }
}

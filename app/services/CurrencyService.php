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

//
//    public function getBaseRate(string $currencyCode): float
//    {
//        /** @var EurExchangeRate $eurExchangeRate */
//        foreach ($this->eurExchangeRates as $eurExchangeRate) {
//            if ($eurExchangeRate->toCurrency() == $currencyCode) {
//                return $eurExchangeRate->getRate();
//            }
//        }
//
//        return 1;
//    }


    public function getExchangeRate(Currency $fromCurrency, Currency $toCurrency): float
    {
        try {
            foreach ([$toCurrency, $fromCurrency] as $currency) {
                $this->canExchange($currency);
            }
        } catch (CurrencyException $currencyException) {
            echo $currencyException->getMessage();
        }

        if ($toCurrency == 'EUR') {
            return 1;
        }

        return $this->eurExchangeRates->getRateForCurrency('EUR') / $this->eurExchangeRates->getRateForCurrency($toCurrency);
    }


    public function getSupportedCurrencies()
    {
        return $this->eurExchangeRates->getSupportedCurrencies();
    }
}

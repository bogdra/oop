<?php

namespace App\Services;

use App\Entities\Currency;
use App\Entities\CurrencyCollection;
use App\Entities\ExchangeRate;
use App\Exception\CurrencyException;
use App\Interfaces\EurCurrencyExchangeInterface;

class CurrencyService
{
    public $currency;
    public $currencyObj;

    /** @var CurrencyCollection */
    private $eurExchangeRates;


    public function __construct(EurCurrencyExchangeInterface $randomCurrencyExchange)
    {
        $this->eurExchangeRates = $randomCurrencyExchange->getEurCollection();
    }


    public function generateCollectionForCurrency(Currency $currency): CurrencyCollection
    {
        $eurToDesiredCurrencyRate = 1 / $this->eurExchangeRates->getRateForCurrency($currency);
        $newCurrencyCollection = new CurrencyCollection($currency);
        /** @var $item ExchangeRate */
        foreach ($this->eurExchangeRates->getCurrencies() as $item) {
            //check if the currency Object is already in the eurExchangeRates Collection in order to not show it
            if ($item->getToCurrency() == $currency->__toString()) {
                continue;
            }
            $newCurrencyCollection->add(
                new ExchangeRate(
                    $item->getToCurrency(),
                    round($eurToDesiredCurrencyRate * $item->getRate(), 2)
                )
            );
        }
        return $newCurrencyCollection;
    }


    //generates a new CurrencyCollection of a specific given currency
    public function getExchangeRatesForSpecificCurrency(Currency $currency): CurrencyCollection
    {
        $rates = [];
        foreach ($this->eurExchangeRates->getSupportedCurrenciesCodes() as $item) {

            if ($item->__toString() == $currency->__toString()) {
                continue;
            }
            $rates[] = new ExchangeRate($item, $this->getExchangeRate($currency, new Currency($item)));
        }
        return $rates;
    }


    public function getExchangeRate(Currency $fromCurrency, Currency $toCurrency): float
    {
        try {
            foreach ([$toCurrency, $fromCurrency] as $currency) {
                $this->canExchange($currency);
            }
            $fromCurrencyToEurRate = 1 / $this->eurExchangeRates->getRateForCurrency(new Currency($fromCurrency));
            $forCurrencyRate = $this->eurExchangeRates->getRateForCurrency(new Currency($toCurrency));
        } catch (CurrencyException $currencyException) {
            echo $currencyException->getMessage();
        }
        return round($fromCurrencyToEurRate * $forCurrencyRate, 2);
    }


    private function canExchange(Currency $currency): void
    {
        if (!$this->eurExchangeRates->hasCurrencyRate($currency)) {
            throw new CurrencyException('the given Currency is not present in the array currencies');
        }
    }


    public function getSupportedCurrencies(): array
    {
        return $this->eurExchangeRates->getSupportedCurrenciesCodes();
    }
}

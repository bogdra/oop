<?php


namespace App\Entities;


use http\Exception\InvalidArgumentException;

class CurrencyCollection
{
    /** @var Currency $fromCurrency */
    private $fromCurrency;
    private $items = [];

    public function __construct(Currency $currency, array $items = [])
    {
        $this->fromCurrency = $currency;

        foreach ($items as $item) {
            if (!$item instanceof ExchangeRate) {
                throw new InvalidArgumentException('invalid input');
            }

            if ($this->checkExchangeRateIsNotForCurrency($item, $this->fromCurrency)) {
                $this->add($item);
            }
        }
        //insert into the EurExchangeRate the rate for EUR -> EUR
        $this->add(new ExchangeRate($currency, 1));
    }


    //adds anew Currency to the collection
    private function checkExchangeRateIsNotForCurrency(ExchangeRate $item, Currency $currency): bool
    {
        if ($item->getToCurrency()->__toString() === $$currency->__toString()) {
            return false;
        }
        return true;
    }


    // returns the currency rate from EUR -> $currency
    public function add(ExchangeRate $exchangeRate): void
    {
        array_push($this->items, $exchangeRate);
    }


    public function getRateForCurrency(Currency $toCurrency): float
    {
        /** @var ExchangeRate $item */
        foreach ($this->items as $item) {
            if ($item->getToCurrency()->__toString() === $toCurrency->__toString()) {
                return round($item->getRate(), 2);
            }
        }
        return 1;
    }


    public function hasCurrencyRate(Currency $currency): bool
    {
        /** @var ExchangeRate $item */
        foreach ($this->getSupportedCurrenciesCodes() as $item) {
            if ($item->getToCurrency()->__toString() === $currency->__toString()) {
                return true;
            }
        }
        return false;
    }


    //returns an array of  the Currency objects that are supported for exchange
    public function getSupportedCurrenciesCodes(): array
    {
        $codes = [];

        /** @var ExchangeRate $eurExchangeRate */
        foreach ($this->items as $eurExchangeRate) {
            $codes[] = $eurExchangeRate->getToCurrency();
        }
        \array_unshift($codes, new Currency('EUR'));

        return $codes;
    }


    public function getFromCurrency(): Currency
    {
        return $this->fromCurrency;
    }

    //returns the array of ExchangeRate objects
    public function getCurrencies(): array
    {
        return $this->items;
    }

    //formats the CurrencyCollection Object to Array of Simple objects with Public Properties
    public function formatCurrencyCollectionForApi(): array
    {
        $arrayOfObjects = [];
        /** @var ExchangeRate $item */
        foreach ($this->items as $item) {

            $arrayOfObjects[] = (object)[
                'toCurrency' => $item->getToCurrency()->__toString(),
                'rate' => $item->getRate()
            ];
        }
        return $arrayOfObjects;
    }
}
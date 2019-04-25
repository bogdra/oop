<?php


namespace App\Entities;


use http\Exception\InvalidArgumentException;

class CurrencyCollection
{

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
    public function add(ExchangeRate $exchangeRate): void
    {
        array_push($this->items, $exchangeRate);
    }


    // returns the currency rate from EUR -> $currency
    public function getRateForCurrency(Currency $toCurrency): float
    {
        foreach ($this->items as $item) {
            if ($item->getToCurrency()->__toString() === $toCurrency->__toString()) {
                return round($item->getRate(), 2);
            }
        }
        return 1;
    }


    public function hasCurrencyRate(Currency $currency): bool
    {
        foreach ($this->getSupportedCurrenciesCodes() as $item) {
            if ($item == $currency) {
                return true;
            }
        }
        return false;
    }


    //returns an array of  the codes  of the currencies that are supported for exchange
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


    public function getCurrencies(): array
    {
        return $this->items;
    }


    //validates that the exchange rate given is not the main Currency
    private function checkExchangeRateIsNotForCurrency(ExchangeRate $item, Currency $currency): bool
    {
        if ($item->getToCurrency()->__toString() === $$currency->__toString()) {
            return false;
        }
        return true;
    }

    public function formatCurrencyCollectionForJson(CurrencyCollection $collection)
    {
        $arrayOfItems = [];
        /** @var ExchangeRate $item */
        foreach ($collection as $item)
        {
            $temp['toCurrency'] = $item->getToCurrency();
            $temp['rate'] = $item->getRate();
            $arrayOfItems[] = (object)$temp;
        }
        return $arrayOfItems;
    }
}
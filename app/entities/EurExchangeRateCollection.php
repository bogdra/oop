<?php


namespace App\Entities;


use http\Exception\InvalidArgumentException;

class EurExchangeRateCollection
{

    private $items = [];

    //you can instantiate it with an array of EurExchangeRate or an empty array
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if (!$item instanceof EurExchangeRate) {
                throw new InvalidArgumentException('invalid input');
            }

            $this->add($item);
        }
    }

    //adds anew Currency to the collection
    public function add(EurExchangeRate $eurExchangeRate): void
    {
        array_push($this->items, $eurExchangeRate);
    }

    // returns the currency rate from EUR -> $currency
    public function getRateForCurrency(Currency $currency): float
    {

        foreach ($this->items as $item) {
            if ($item->getToCurrency()->__toString() === $currency->__toString()) {
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

        /** @var EurExchangeRate $eurExchangeRate */
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

}
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
    public function add(EurExchangeRate $eurExchangeRate)
    {
        array_push($this->items, $eurExchangeRate);
    }


    public function getRateForCurrency(string $currency)
    {
        foreach ($this->items as $item) {
            if ($item->toCurrency() == $currency) {
                return $item->getRate();
            }
        }
    }


    public function hasCurrencyRate(Currency $currency)
    {
        //todo iterate and return true or false
    }

    public function getSupportedCurrencies(): array
    {
        $codes = [];

        /** @var EurExchangeRate $eurExchangeRate */
        foreach ($this->items as $eurExchangeRate) {
            $codes[] = $eurExchangeRate->toCurrency();
        }
        \array_unshift($codes, "EUR");

        return $codes;
    }
}
<?php


namespace App\Entities;


class EurExchangeRate
{
    public function __construct(Currency $toCurrency, float $rate)
    {
        $this->toCurrency = $toCurrency;
        $this->rate = $rate;
    }
}
<?php


namespace App\Entities;


class ExchangeRate
{
    private $toCurrency;
    private $rate;


    public function __construct(Currency $toCurrency, float $rate)
    {
        $this->toCurrency = $toCurrency;
        $this->rate = $rate;
    }


    public function getToCurrency()
    {
        return $this->toCurrency;
    }


    public function getRate()
    {
        return $this->rate;
    }
}
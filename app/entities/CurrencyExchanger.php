<?php

namespace App\Entities;

class CurrencyExchanger
{
    protected $currencyFrom;
    protected $currencyTo;
    protected $rate;


    public function __construct(Currency $currencyFrom, Currency $currencyTo, float $rate)
    {
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->rate = $rate;
    }


    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }


    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    public function getRate(): float
    {
        return $this->rate;
    }


    public function exchange(float $amount): float
    {
        return $this->getRate() * $amount;
    }
}
<?php
namespace App\Entities;

class currencyEntity
{
    protected $currencyFrom;
    protected $currencyTo;
    protected $rate;

    public function __construct(string $currencyFrom, string $currencyTo, float $rate)
    {
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
        $this->rate = $rate;
    }

    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo()
    {
        return $this->currencyTo;
    }

    public function getRate()
    {
        return $this->rate;
    }

}
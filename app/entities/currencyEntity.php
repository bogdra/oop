<?php
namespace App\Entities;

class currencyEntity
{
    public $currencyFrom;
    public $currencyTo;
    public $rate;

    public function __construct(string $currencyFrom, string $currencyTo, float $rate)
    {
        $this->currencyFrom    = $currencyFrom;
        $this->currencyTo       = $currencyTo;
        $this->rate             = $rate;
    }

}
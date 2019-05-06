<?php


namespace App\Entities;


use App\Exception\CurrencyException;

class Currency
{
    private $currency;

    public function __construct(string $currency)
    {
        if (strlen($currency) != 3) {
            throw new CurrencyException('Currency length is wrong!');
        }

        if (!ctype_alpha($currency)) {
            throw new CurrencyException('Currency cant contain anything other that alphabetic chars!');
        }

        $this->currency = $currency;
    }

    public function __toString(): string
    {
        return $this->currency;
    }
}
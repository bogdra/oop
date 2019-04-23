<?php


namespace App\Entities;


use App\Exception\CurrencyException;
use mysql_xdevapi\Exception;

class Currency
{
    private $currency;

    public function __construct(string $currency)
    {
        if (strlen($currency) != 3) {
            throw new CurrencyException('Currency length is wrong!');
        }

        $this->currency = $currency;
    }

    public function __toString(): string
    {
        return $this->currency;
    }
}
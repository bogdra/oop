<?php


namespace App\Entities;


use App\Exceptions\CurrencyLengthInvalidException;
use App\Exceptions\CurrencyCharacterTypeInvalidException;


class Currency
{
    private $currency;

    public function __construct(string $currency)
    {
        if (strlen($currency) != 3) {
            throw new CurrencyLengthInvalidException('Currency length is wrong!');
        }

        if (!ctype_alpha($currency)) {
            throw new CurrencyCharacterTypeInvalidException('Currency cant contain anything other that alphabetic chars!');
        }

        $this->currency = $currency;
    }


    public function __toString(): string
    {
        return $this->currency;
    }
}
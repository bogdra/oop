<?php


namespace App\Entities;


use App\Exceptions\Currency\CurrencyCommissionToValueSmallerThanFromValueException;
use App\Exceptions\Currency\CurrencyCommissionElementSmallerOrEqualToZeroException;


class Commission
{

    private $from;
    private $to;
    private $commission;

    public function __construct(float $fromValue, float $toValue, float $commissionValue)
    {
        if ($fromValue > $toValue) {
            throw new CurrencyCommissionToValueSmallerThanFromValueException
            ('The toValue must be grater or equal with the fromValue');
        }

        foreach ([$fromValue, $toValue, $commissionValue] as $value) {
            if ($value < 0) {
                throw new CurrencyCommissionElementSmallerOrEqualToZeroException
                ('value must be greater or equal to 0');
            }
        }

        $this->from = $fromValue;
        $this->to = $toValue;
        $this->commission = $commissionValue;
    }


    public function getCommissionValue()
    {
        return $this->commission;
    }


    public function fitsCommissionRule(int $amount): bool
    {
        if (($amount <= $this->to) && ($amount >= $this->from)) {
            return true;
        }
        return false;
    }
}
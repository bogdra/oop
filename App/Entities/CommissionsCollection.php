<?php


namespace App\Entities;


use App\Exceptions\Currency\CurrencyCommissionRuleMustHaveThreeElementsException;


class CommissionsCollection
{

    private $commissionRules = [];
    private $usedCurrency;


    public function __construct(string $commissionCurrency, array $commissionsRules)
    {
        if (count($commissionsRules) != 3) {
            throw new CurrencyCommissionRuleMustHaveThreeElementsException
            ('The commissions rule array must have 3 elements');
        }

        $this->usedCurrency = new Currency($commissionCurrency);

        foreach (COMMISSIONS as $commission) {
            $this->commissionRules[] = new Commission(
                $commission['valueFrom'],
                $commission['valueTo'],
                $commission['commission']);
        }
    }

    public function getCommissions(): array
    {
        return $this->commissionRules;
    }

    public function getUsedCurrency(): Currency
    {
        return $this->usedCurrency;
    }
}

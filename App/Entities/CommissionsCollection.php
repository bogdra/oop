<?php

namespace App\Entities;


class CommissionsCollection
{

    private $commissionRules = [];
    private $usedCurrency;


    public function __construct(string $commissionCurrency, array $commissionsRules)
    {
        if (!count($commissionsRules)) {
            throw new \Exception('The commission constant can\'t be empty');
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

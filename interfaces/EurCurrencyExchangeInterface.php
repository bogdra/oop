<?php


namespace App\Interfaces;


use App\Entities\CurrencyCollection;

/**
 * @return CurrencyCollection
 */
interface EurCurrencyExchangeInterface
{
    public function getEurCollection();
}
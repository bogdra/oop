<?php


namespace App\Services;


use App\Entities\Currency;
use App\Entities\CurrencyCollection;
use App\Entities\ExchangeRate;
use App\Interfaces\EurCurrencyExchangeInterface;
use App\Exceptions\FileException;

class ECBCurrencyExchange implements EurCurrencyExchangeInterface
{

    protected $url;


    public function __construct(string $url = INPUT_SOURCE)
    {
        $this->url = $url;
    }


    public function getEurCollection(): CurrencyCollection
    {
        if (!file_get_contents($this->url)) {
            throw new FileException('The Exchange currency local file does not exists or could not be open');
        }

        $eurExchangeRateCollection = new CurrencyCollection(new Currency('EUR'));

        $currenciesObjs = new \SimpleXMLElement(file_get_contents($this->url));

        //injecting the EUR parity into the EUR Currency Collection
        $eurExchangeRateCollection->add(new ExchangeRate(new Currency('EUR'), 1));

        foreach ($currenciesObjs->Cube->Cube->children() as $currencyParity) {
            $eurExchangeRateCollection->add(
                new ExchangeRate(
                    new Currency($currencyParity->attributes()['currency']),
                    round((float)$currencyParity->attributes()['rate'], 2)
                ));
        };

        return $eurExchangeRateCollection;
    }
}
<?php


namespace App\Services;


use App\Entities\Currency;
use App\Entities\EurExchangeRate;
use App\Entities\EurExchangeRateCollection;
use App\Exception\FileException;
use Core\Helper;

class ECBCurrencyExchange implements EurCurrencyExchange
{

    protected $url;

    public function __construct(string $url)
    {
        $this->url = $url;

        if (!Helper::remoteFileExists($this->url)) {
            throw new FileException('The Exchange currency file does not exists');
        }
    }

    public function getEurRates(): EurExchangeRateCollection
    {
        $eurExchangeRateCollection = new EurExchangeRateCollection();
        //todo what happens on false
        $xmlRawInput = file_get_contents($source);

        $currenciesObjs = new SimpleXMLElement($xmlRawInput);

        foreach ($currenciesObjs->Cube->Cube->children() as $currencyParity) {
            $eurExchangeRateCollection->add(
                new EurExchangeRate(
                    new Currency($currencyParity->attributes()['currency']),
                    (float)$currencyParity->attributes()['rate']
                ));
        };

        return $eurExchangeRateCollection;
    }
}
<?php


namespace App\Services;


use App\Entities\Currency;
use App\Entities\EurExchangeRate;
use App\Entities\EurExchangeRateCollection;
use App\Interfaces\EurCurrencyExchangeInterface;
use App\Exception\FileException;
use Core\Helper;

class ECBCurrencyExchange implements EurCurrencyExchangeInterface
{

    protected $url;

    public function __construct(string $url = INPUT_SOURCE)
    {
        $this->url = $url;

        if (!Helper::remoteFileExists($this->url)) {
            throw new FileException('The Exchange currency remote file does not exists');
        }
    }

    public function getEurRates(): EurExchangeRateCollection
    {

        if(!file_get_contents($this->url))
        {
            throw new FileException('The Exchange currency local file does not exists or could not be open');
        }

        $eurExchangeRateCollection = new EurExchangeRateCollection();

        $currenciesObjs = new \SimpleXMLElement(file_get_contents($this->url));

        foreach ($currenciesObjs->Cube->Cube->children() as $currencyParity) {
            $eurExchangeRateCollection->add(
                new EurExchangeRate(
                    new Currency($currencyParity->attributes()['currency']),
                    round((float)$currencyParity->attributes()['rate'], 2)
                ));
        };

        return $eurExchangeRateCollection;
    }
}
<?php


namespace App\Services;


use App\Entities\Currency;
use App\Entities\CurrencyCollection;
use App\Entities\ExchangeRate;
use App\Interfaces\EurCurrencyExchangeInterface;
use App\Exceptions\Currency\CurrencyNotInPermittedCurrenciesException;
use App\Exceptions\Currency\CurrencyCharacterTypeInvalidException;
use App\Exceptions\Currency\CurrencyLengthInvalidException;
use App\Traits\Log;


class CurrencyService
{
    public $currency;
    public $currencyObj;

    use Log;


    /** @var CurrencyCollection */
    private $eurExchangeRates;


    public function __construct(EurCurrencyExchangeInterface $randomCurrencyExchange)
    {
        $this->eurExchangeRates = $randomCurrencyExchange->getEurCollection();
    }


    public function generateCollectionForCurrency(Currency $currency): CurrencyCollection
    {
        $eurToDesiredCurrencyRate = 1 / $this->eurExchangeRates->getRateForCurrency($currency);
        $newCurrencyCollection = new CurrencyCollection($currency);

        /** @var $item ExchangeRate */
        foreach ($this->eurExchangeRates->getCurrencies() as $item) {
            //check if the currency Object is already in the eurExchangeRates Collection in order to not show it
            if ($item->getToCurrency() == $currency->__toString()) {
                continue;
            }
            $newCurrencyCollection->add(
                new ExchangeRate(
                    $item->getToCurrency(),
                    round($eurToDesiredCurrencyRate * $item->getRate(), 2)
                )
            );
        }
        return $newCurrencyCollection;
    }


    //generates a new CurrencyCollection of a specific given currency
    public function getExchangeRatesForSpecificCurrency(Currency $currency): CurrencyCollection
    {
        try {
            $rates = [];
            foreach ($this->eurExchangeRates->getSupportedCurrenciesCodes() as $item) {

                if ($item->__toString() == $currency->__toString()) {
                    continue;
                }
                $rates[] = new ExchangeRate($item, $this->getExchangeRate($currency, new Currency($item)));
            }
        } catch (CurrencyLengthInvalidException $e) {
            $this->logger->critical($e->getMessage());
            //TODO: redirect to error page

        } catch (CurrencyCharacterTypeInvalidException $e) {
            $this->logger->critical($e->getMessage());
            //TODO: redirect to error page

        } catch (\Throwable $e) {
            $this->logger->warning($e->getMessage());
        }

        return new CurrencyCollection($currency, $rates);
    }


    public function getExchangeRate(Currency $fromCurrency, Currency $toCurrency): float
    {
        foreach ([$toCurrency, $fromCurrency] as $currency) {
            $this->canExchange($currency);
        }
        $fromCurrencyToEurRate = 1 / $this->eurExchangeRates->getRateForCurrency(new Currency($fromCurrency));
        $forCurrencyRate = $this->eurExchangeRates->getRateForCurrency(new Currency($toCurrency));

        return round($fromCurrencyToEurRate * $forCurrencyRate, 2);
    }


    private function canExchange(Currency $currency): void
    {
        if (!$this->eurExchangeRates->hasCurrencyRate($currency)) {
            throw new CurrencyNotInPermittedCurrenciesException
            ('the given currency ('.$currency.') is not present in the array currencies');
        }
    }


    public function getSupportedCurrencies(): array
    {
        return $this->eurExchangeRates->getSupportedCurrenciesCodes();
    }
}

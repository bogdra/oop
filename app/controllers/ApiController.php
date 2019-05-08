<?php


namespace App\Controller;


use \Core\Router;
use \App\Entities\Currency;
use \App\Services\CurrencyService;
use \App\Services\ApiService;
use \App\Services\ECBCurrencyExchange;
use \App\Exception\CurrencyException;
use \App\Exception\RequestException;


class ApiController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Route used is /api/convert/from/{currencyFrom}/to/{currencyTo}/value/{currencyValue}
     */
    public function convertAction(): void
    {
        try {
            $this->allowedRequestMethods(['GET']);
            Router::routeRuleValidation(func_get_args(), 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}');
            list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = func_get_args();

            $currencyService = new CurrencyService(new ECBCurrencyExchange());
            $rate = $currencyService->getExchangeRate(new Currency($fromCurrency), new Currency($toCurrency));

            $apiService = new ApiService('success', [
                'ConvertedValue' => round((float)$currencyValue * $rate, 2),
                'ConversionRate' => $rate
            ]);
            print_r($apiService->getResponse());

        } catch (RequestException $requestException) {
            echo $requestException->getApiMessage();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }


    /*
    * Route used is /api/exchange/get/{currency}
    */
    public function exchangeAction(): void
    {
        try {
            $this->allowedRequestMethods(['GET']);
            Router::routeRuleValidation(func_get_args(), 'get/{alpha[3]}');
            list($get, $givenCurrency) = func_get_args();


            $currencyObj = new CurrencyService(new ECBCurrencyExchange);
            $response = $currencyObj
                ->generateCollectionForCurrency(new Currency($givenCurrency))
                ->formatCurrencyCollectionForApi();

            $apiService = new ApiService('success', $response);
           // var_dump($apiService->getResponse())->data;die();
            print_r($apiService->getResponse()->getResponse());

        } catch (RequestException $requestException) {
            echo $requestException->getMessage();
        } catch (CurrencyException $currencyException) {
            echo $currencyException->getMessage();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}

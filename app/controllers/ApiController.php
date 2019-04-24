<?php

namespace App\Controller;

use App\Entities\Currency;
use \App\Exception\CurrencyException;
use \App\Exception\RequestException;
use \App\Services\CurrencyService;
use \App\Services\ApiService;
use App\Services\ECBCurrencyExchange;
use \Core\Router;

class ApiController extends Controller
{
    public $apiService;

    public function __construct()
    {
        parent::__construct();
        $this->apiService = new ApiService();
    }

    /*
     * Route used is /api/convert/from/{currencyFrom}/to/{currencyTo}/value/{currencyValue}
     */
    public function convertAction()
    {

        try {
            //
            $this->allowedRequestMethods(['GET']);
            $params = func_get_args();
            Router::routeRuleValidation($params, 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}');
            list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = $params;

            $currencyService = new CurrencyService(new ECBCurrencyExchange());

            foreach ($currencyService->toArray() as $currencyObj) {
                if ($currencyObj['currencyTo'] == strtoupper($toCurrency)) {
                    $answer = $currencyObj['rate'] * (float)$currencyValue;
                    $this->apiService->setResponse(
                        'success', [
                            'ConvertedValue' => $answer,
                            'ConversionRate' => $currencyObj['rate']
                        ]
                    );
                    print_r($this->apiService->jsonResponse());
                    break;
                }
            }

        } catch (RequestException $requestException) {
            echo $requestException->getApiMessage();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    /*
    * Route used is /api/exchange/{currency}
    */
    public function exchangeAction()
    {
        try {
            $this->allowedRequestMethods(['GET']);
            $params = func_get_args();
            Router::routeRuleValidation($params, 'get/{alpha[3]}');

            $currencyObj = new CurrencyService(new ECBCurrencyExchange);

            $response = $currencyObj->getExchangeRatesForSpecificCurrency(new Currency($params[1]));
            // Need to modify the response and the interpretation of the response to fit the api response type
            print_r(json_encode($response));

        } catch (RequestException $requestException) {
            echo $requestException->getMessage();
        } catch (CurrencyException $currencyException) {
            echo $currencyException->getMessage();
        }
    }
}

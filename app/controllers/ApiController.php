<?php

namespace App\Controller;

use App\Entities\Currency;
use \App\Exception\CurrencyException;
use \App\Exception\RequestException;
use \App\Services\CurrencyService;
use \App\Services\ApiService;
use App\Services\ECBCurrencyExchange;
use \App\Services\ErrorService;
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
            //




            $currencyService = new CurrencyService(new ECBCurrencyExchange(''));

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
        } catch (CurrencyException $currencyException) {
            echo $currencyException->getApiMessage();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}

<?php
namespace App\Controller;

use App\Exception\CurrencyException;
use App\Exception\RequestException;
use \App\Services\CurrencyService;
use \App\Services\ApiService;

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
        try
        {
            $this->allowedRequestMethods(['GET']);
            $params = func_get_args();
            $this->apiService->hasRightNumberOfParameters($params, 6);

            foreach(['from', 'to', 'value'] as $keyword)
            {
                $this->apiService->hasRightKeywordInRoute($params, $keyword);
            }
        }
        catch (RequestException $requestException)
        {
            echo $requestException->getMessage();
        }

        list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = $params;

        $currencyService = new CurrencyService(strtoupper($fromCurrency));
         try
         {
             $currencyService->checkCurrencyCodeInArrayOfAvailableCurrencies([$fromCurrency, $toCurrency]);
         }
         catch (CurrencyException $currencyException)
         {
             echo $currencyException->getMessage();
         }


        foreach ($currencyService->toArray() as $currencyObj)
        {
            $found = false;
            if ($currencyObj['currencyTo'] == strtoupper($toCurrency))
            {
               $found = true;
               $answer = $currencyObj['rate'] * (float)$currencyValue;
               $this->apiService->setResponse($answer);
               print_r($this->apiService->jsonResponse());
               break;
            }
        }

        if ($found == false)
        {
            $this->apiService->setResponse('',204);
            print_r($this->apiService->jsonResponse());
        }

    }
}


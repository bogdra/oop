<?php
namespace App\Controller;

use \App\Services\CurrencyService;
use \App\Services\ApiService;



class ConvertController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function fromAction($currencyFrom, $action1, $currencyTo, $action2, $value)
    {
        $this->allowedRequestMethods(['GET']);
        $params = func_get_args();

        if (count($params) != 5)
        {
            $response = new ApiService('You do not have the right number of elements in the route', 405);
            return $response->jsonResponse();
        }
        else
        {
            list($fromCurrency, $to, $toCurrency, $value, $currencyValue) = $params;
        }

        if (strtolower($to)  != 'to')
        {
            $response = new ApiService('Missing to keyword from route', 405);
            return $response->jsonResponse();
        }
        if (strtolower($value)  != 'value')
        {
            $response = new ApiService('Missing value keyword from route', 405);
            return $response->jsonResponse();
        }

        $currencyService = new CurrencyService(strtoupper($fromCurrency));
        foreach ($currencyService->toArray() as $currencyObj)
        {
           if ($currencyObj['currencyTo'] == strtoupper($toCurrency))
           {
               $answer = $currencyObj['rate'] * (float)$currencyValue;
               $response = new ApiService($answer);
               return $response->jsonResponse();
           }
        }

        $response = new ApiService('',204);
        return $response->jsonResponse();
    }
}


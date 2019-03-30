<?php
namespace App\Controller;

use App\Services\CurrencyService;
use App\Exception\RequestException;

class ExchangeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getAction(string $currency = '')
    {
        try
        {
            $this->allowedRequestMethods(['POST']);
        }
        catch (RequestException $e)
        {
           throw $e;
        }

        $currencyRates =  new CurrencyService();

        print_r(json_encode($currencyRates->convertTo($currency)));

    }
}


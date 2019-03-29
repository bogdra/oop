<?php
namespace App\Controller;

use App\Services\CurrencyService;

class ExchangeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getAction(string $currency = '')
    {
        $this->allowedRequestMethods(['POST']);

        $currencyRates =  new CurrencyService();

        print_r(json_encode($currencyRates->convertTo($currency)));

    }
}


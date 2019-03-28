<?php
namespace App\Controller;

use App\Core\Controller;
use App\Services\CurrencyService;

class ExchangeController extends Controller
{
    public $currencyRates;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRates =  new CurrencyService();
    }


    public function getAction(string $currency = '')
    {
        $this->allowedRequestMethods(['GET']);

       // print_r($this->currencyRates->convertTo($currency));
        print_r($this->currencyRates->getBaseConversionRate('RON'));
       // print_r($this->currencyRates->getExchangeRatesObjectsArray());
    }
}


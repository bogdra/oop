<?php
namespace App\Controller;

use App\Core\Controller;
use App\Model\ExchangeModel;

class ExchangeController extends Controller
{
    public $currencyRates;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRates =  new ExchangeModel();
    }


    public function getAction(string $currency)
    {
        $this->allowedRequestMethods(['GET']);

        print_r(json_encode($this->currencyRates->convertTo($currency)));
    }
}

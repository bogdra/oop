<?php

namespace App\Controller;

use App\Services\CurrencyService;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function indexAction()
    {
        $this->view->setTitle('Homepage');
        $currency = new CurrencyService();

        $params = [
            'currencyArrayKeys' => $currency->getExchangeRatesKeys()
        ];
        $this->view->render('home/index', $params);
    }
}
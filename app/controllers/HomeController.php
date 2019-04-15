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
        $currencyService = new CurrencyService();
        $this->view->setTitle('Homepage');

        $params = [
            'currencyArrayKeys' => $currencyService->getExchangeRatesKeys()
        ];

        $this->view->render('home/index', $params);
    }
}
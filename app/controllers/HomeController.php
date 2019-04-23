<?php

namespace App\Controller;

use App\Services\CurrencyService;
use App\Services\ECBCurrencyExchange;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function indexAction(): void
    {
        $this->view->setTitle('Homepage');

        $currencyService = new CurrencyService(new ECBCurrencyExchange());

        $params = [
            'currencyArrayKeys' => $currencyService->getSupportedCurrencies(),
        ];

        $this->view->render('home/index', $params);
    }
}
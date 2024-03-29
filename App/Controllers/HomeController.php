<?php


namespace App\Controllers;


use App\Services\CurrencyService;
use App\Services\ECBCurrencyExchange;


class HomeController extends Controller
{


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

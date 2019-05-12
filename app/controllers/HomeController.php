<?php

namespace App\Controller;

use App\Exception\ViewException;
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
        try
        {
            $this->view->setTitle('Homepage');

            $currencyService = new CurrencyService(new ECBCurrencyExchange());

            $params = [
                'currencyArrayKeys' => $currencyService->getSupportedCurrencies(),
            ];

            $this->view->render('home/index', $params);

        } catch(ViewException $viewException)
        {
            echo $viewException->getCustomMessage();
        }
    }
}

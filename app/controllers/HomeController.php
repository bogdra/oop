<?php
namespace App\Controller;

use App\Services\CurrencyService;
use App\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


   public function indexAction()
   {
        $currency =  new CurrencyService();

        $params = [
            'currencyArrayKeys' => $currency->getCurrencyRatesKeys()
        ];

        $this->view->render('home/index', $params);
   }
}
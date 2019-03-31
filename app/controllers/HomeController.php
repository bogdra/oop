<?php
namespace App\Controller;

use App\Services\CurrencyService;
use Core\DB;
use Core\H;

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
            'currencyArrayKeys' => $currency->getExchangeRatesKeys()
        ];

        $this->view->render('home/index', $params);
   }
}
<?php
namespace App\Controller;

use App\Model\ExchangeModel;

class HomeController extends \App\Core\Controller
{
    public $currency;

    public function __construct()
    {
        parent::__construct();
        $this->currency =  new ExchangeModel();
    }

   public function indexAction()
   {
        $params = [
            'currencyArray' => $this->currency->getCurrencyRatesArray()
        ];

        $this->view->render('home/index', $params);
   }
}
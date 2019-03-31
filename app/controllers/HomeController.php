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
       try
       {
           $db = \Core\DB::init();
           if($db->read('eurparities', ['conditions' =>'id = 1']))
           {
               $db->getResult();
           }
       }
       catch(\PDOException $pdoException)
       {
           echo($pdoException->getMessage());
       }

             H::dnd($db->result);
        $currency =  new CurrencyService();

        $params = [
            'currencyArrayKeys' => $currency->getExchangeRatesKeys()
        ];

        $this->view->render('home/index', $params);
   }
}
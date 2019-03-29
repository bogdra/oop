<?php
namespace App\Controller;

<<<<<<< HEAD
use App\Model\ExchangeModel;

class HomeController extends \App\Core\Controller
=======
class HomeController extends Controller
>>>>>>> d278e90a4b5cfd1427ad7264218375a74fa07bff
{
    public $currency;

    public function __construct()
    {
        parent::__construct();
        $this->currency =  new ExchangeModel();
    }


   public function indexAction()
   {
       // \Core\H::dnd($this->currency->getCurrencyRatesKeys());
        $params = [
            'currencyArrayKeys' => $this->currency->getCurrencyRatesKeys()
        ];

        $this->view->render('home/index', $params);
   }
}
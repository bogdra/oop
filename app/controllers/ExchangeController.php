<?php
namespace App\Controller;

use App\Core\Controller;
use App\Model\ExchangeModel;

class ExchangeController extends Controller
{
    public $currencyRates;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRates =  new ExchangeModel();
    }

   public function indexAction()
   {
        echo('index');
   }

    public function getAction(string $currency)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            die('Wrong request type');
        }

        var_dump( $this->currencyRates->convertTo($currency));
    }
}

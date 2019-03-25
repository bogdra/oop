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
            'falcuta'=>'test',
            'radu'=>'frumos'
        ];

      echo('<pre>'); var_dump($this->currency->test()->attributes()[0][0]);  echo('</pre>');

      foreach($this->currency->test()->attributes()[0] as $key => $value)
      {
          print_r($value);
      }
       $this->view->render('home/index', $params);
   }
}
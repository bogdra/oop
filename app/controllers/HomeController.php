<?php
namespace App\Controller;

class HomeController extends \App\Core\Controller
{
    public function __construct()
    {
        parent::__construct();
    }
   public function test()
   {
       echo 'test';
   }

   public function indexAction()
   {
        $params = [
            'falcuta'=>'test',
            'radu'=>'frumos'
        ];

        $this->view->render('home/index', $params);
   }
}
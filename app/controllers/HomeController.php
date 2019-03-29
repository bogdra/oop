<?php
namespace App\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
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
<?php
namespace App\Controller;

class ConvertController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $params = $_GET;
        \Core\H::dnd($params);
    }

    public function fromAction($currencyFrom, $action1, $currencyTo, $action2,$value)
    {
        $params = $_GET;
        \Core\H::dnd(func_get_args());
    }
}

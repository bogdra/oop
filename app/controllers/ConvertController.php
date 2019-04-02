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
}

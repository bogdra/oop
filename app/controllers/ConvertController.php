<?php
namespace App\Controller;

use App\Exception\CurrencyException;
use \Core\H;
use \App\Services\CurrencyService;



class ConvertController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $params = $_GET;
        H::dnd($params);
    }

    public function fromAction($currencyFrom, $action1, $currencyTo, $action2, $value)
    {


        $this->allowedRequestMethods(['GET']);
        $params = func_get_args();
       // H::dnd( $params);

        if ( count($params) != 5 )
        {
            throw new \Exception('Wrong Format');
        }

        if (strtolower($params[1])  != 'to')
        {
            throw new \Exception('Missing \"To\" keyword ');
        }

        if (strtolower($params[3])  != 'value')
        {
            throw new \Exception('Missing Value keyword ');
        }

        $fromCurrency = strtoupper($params[0]);
        $toCurrency = strtoupper($params[2]);
        $value = (float)$params[4];

        $currencyService = new CurrencyService($fromCurrency);

        foreach ($currencyService->toArray() as $currencyObj)
        {
           if ($currencyObj['currencyTo'] == $toCurrency)
           {
               $answer = $currencyObj['rate'] * $value;
                break;
           }

        }


       // H::dnd($currencyService->toArray());

    }
}

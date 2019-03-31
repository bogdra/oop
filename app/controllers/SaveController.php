<?php
namespace App\Controller;

use \Core\DB;
use \App\Services\CurrencyService;

class SaveController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function exchangeAction($destination)
    {
        if ($destination == 'db')
        {
            $this->allowedRequestMethods(['GET']);
            $db = DB::init();
            $exchangeService = new CurrencyService();
            $EurParities = $exchangeService->getEurExchangeRatesObjectsArray();
            foreach ($EurParities as $eurParity)
            {
                $fields[$eurParity->getCurrencyTo()] = $eurParity->getRate();
            }
            $fields['timestamp'] = date("Y-m-d H:i:s");
            if ($db->insert('eurparities',$fields))
            {
                echo ('Successfully saved the current exchange rates for EUR to the DB');
            } else {
                echo ('Something went wrong during the insert operation');
            }
        }
    }
}
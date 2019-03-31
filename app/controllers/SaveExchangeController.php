<?php
namespace App\Controller;

use Core\DB;
use App\Services\CurrencyService;

class SaveExchangeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function toDbAction()
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
        $db->insert('eurparities',$fields);
    }
}
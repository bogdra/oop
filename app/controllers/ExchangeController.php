<?php
namespace App\Controller;

use App\Services\CurrencyService;
use App\Exception\CurrencyException;
use App\Exception\RequestException;
use App\Exception\FileException;


class ExchangeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getAction(string $currency = '')
    {
        try
        {
            $this->allowedRequestMethods(['GET']);
            $currencyObj =  new CurrencyService($currency);
        }
        catch (RequestException $requestException)
        {
            echo $requestException->getMessage();
        }
        catch (CurrencyException $currencyException)
        {
            echo $currencyException->getMessage();
        }
        catch (FileException $fileException)
        {
            echo $fileException->getMessage();
        }

        print_r(json_encode($currencyObj->toArray()));

    }
}


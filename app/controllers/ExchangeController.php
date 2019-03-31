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
            $currencyRates =  new CurrencyService();

            foreach ($currencyRates->convertTo($currency) as $obj)
            {
                $tempCurrencyArray['currencyFrom'] = $obj->getCurrencyFrom();
                $tempCurrencyArray['currencyTo'] = $obj->getCurrencyTo();
                $tempCurrencyArray['rate'] = $obj->getRate();
                $tempObjectArray[] = (object)$tempCurrencyArray;
            }
            print_r(json_encode($tempObjectArray));
        }
        catch(FileException $fileException)
        {
            echo $fileException->getMessage();
        }
        catch (RequestException $requestException)
        {
            echo $requestException->getMessage();
        }
        catch (CurrencyException $currencyException)
        {
            echo  $currencyException->getMessage();
        }

    }
}


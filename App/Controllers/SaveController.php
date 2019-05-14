<?php

namespace App\Controllers;

use App\Exceptions\FileException;
use App\Services\ECBCurrencyExchange;
use App\Entities\ExchangeRate;
use App\Exceptions\DbSavingOperationFailedException;
use App\Exceptions\InvalidSavingDestinationException;
use \Core\Db;

class SaveController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function exchangeAction($destination)
    {
        try {
            switch ($destination) {
                case 'db':

                    $db = Db::init();

                    $eurCollection = (new ECBCurrencyExchange())->getEurCollection();

                    /** @var ExchangeRate $eurParity */
                    foreach ($eurCollection->getCurrencies() as $eurParity) {
                        if ($eurParity->getToCurrency()->__toString() == $eurCollection->getFromCurrency()->__toString()) {
                            continue;
                        }
                        $fields[$eurParity->getToCurrency()->__toString()] = $eurParity->getRate();
                    }
                    $fields['timestamp'] = date("Y-m-d H:i:s");
                    if ($db->insert('eurparities', $fields)) {
                        echo('Successfully saved the current exchange rates for EUR to the DB');
                    } else {
                        throw new DbSavingOperationFailedException('Something went wrong during the insert operation');
                    }
                    break;
                default:
                    throw new InvalidSavingDestinationException("Please specify where to save the info");
            }
        } catch (FileException $fileException) {
            echo $fileException;
        } catch (DbSavingOperationFailedException $e) {
            echo $e->getCustomMessage();
        } catch (InvalidSavingDestinationException $e) {
            echo $e->getCustomMessage();
        }
    }

}
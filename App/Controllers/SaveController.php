<?php

namespace App\Controllers;

use App\Services\ECBCurrencyExchange;
use App\Entities\ExchangeRate;
use App\Exceptions\Persistance\DbSavingOperationFailedException;
use App\Exceptions\Persistance\InvalidSavingDestinationException;
use App\Exceptions\File\RemoteExchangeFileNotFoundException;
use App\Traits\LoggingTrait;
use \Core\Db;

class SaveController extends Controller
{
    use LoggingTrait;


    public function __construct()
    {
        $this->allowedRequestMethods('GET');
    }


    public function exchangeAction(string $destination): void
    {
        try {
            $eurCollection = (new ECBCurrencyExchange())->getEurCollection();

            switch ($destination) {
                case 'db':

                    $db = Db::init();

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
                    throw new InvalidSavingDestinationException("Please specify where to save the currency rates");
            }
        } catch (
        InvalidSavingDestinationException |
        DbSavingOperationFailedException |
        RemoteExchangeFileNotFoundException
        $e ) {
            $this->logger->critical($e->getMessage());
            echo $e->getCustomMessage();
        } catch (\Throwable $e) {
            $this->logger->warning($e->getMessage());
            echo $e->getMessage();
        }
    }

}

<?php


namespace App\Controllers;


use \Core\Router;
use \App\Entities\Currency;
use \App\Entities\Success;
use \App\Entities\Fail;
use \App\Entities\Error;
use \App\Services\CurrencyService;
use \App\Services\ApiService;
use \App\Services\ECBCurrencyExchange;
use \App\Exceptions\CurrencyException;
use \App\Exceptions\RequestException;
use \App\Exceptions\DifferenceBetweenValidationRuleAndParametersException;
use \App\Exceptions\LengthMismatchBetweenRuleAndParameterException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


class ApiController extends Controller
{
    private $apiService;

    public function __construct()
    {
        parent::__construct();
        $this->apiService = new ApiService();

        $logger = new Logger('api');
        $logger->pushHandler(new StreamHandler(__DIR__.'/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());


    }

    /*
     * Route used is /api/convert/from/{currencyFrom}/to/{currencyTo}/value/{currencyValue}
     */
    public function convertAction(): void
    {
        try {
            $this->allowedRequestMethods(['GET']);
            Router::routeRuleValidation(func_get_args(), 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}');
            list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = func_get_args();

            $currencyService = new CurrencyService(new ECBCurrencyExchange());
            $rate = $currencyService->getExchangeRate(new Currency($fromCurrency), new Currency($toCurrency));


            $this->apiService->setResponse(
                new Success([
                    'ConvertedValue' => round((float)$currencyValue * $rate, 2),
                    'ConversionRate' => $rate
                ])
            );

        } catch (DifferenceBetweenValidationRuleAndParametersException $e) {
            $logger->warning($e->getMessage());
            $this->apiService->setResponse(new Fail($e->getCustomMessage()));
        } catch (LengthMismatchBetweenRuleAndParameterException $e) {
            $logger->warning($e->getMessage());
            $this->apiService->setResponse(new Fail($e->getCustomMessage()));
        }catch (CurrencyException $currencyException) {
            $logger->warning($currencyException->getMessage());
            $this->apiService->setResponse(new Fail($currencyException->getCustomMessage()));
        } catch (\Throwable $e) {
            $logger->warning($e->getMessage());
            $this->apiService->setResponse(new Fail($e->getMessage()));
        }
    }


    /*
    * Route used is /Api/exchange/get/{currency}
    */
    public function exchangeAction(): void
    {
        try {
            $this->allowedRequestMethods(['GET']);
            Router::routeRuleValidation(func_get_args(), 'get/{alpha[3]}');
            list($get, $givenCurrency) = func_get_args();

            $currencyObj = new CurrencyService(new ECBCurrencyExchange);
            $response = $currencyObj
                ->generateCollectionForCurrency(new Currency($givenCurrency))
                ->formatCurrencyCollectionForApi();

            $this->apiService->setResponse(new Success($response));

        } catch (RequestException $requestException) {
            $logger->warning($requestException->getMessage());
            $this->apiService->setResponse(
                new Fail($requestException->getCustomMessage())
            );
        } catch (CurrencyException $currencyException) {
            $logger->warning($currencyException->getMessage());
            $this->apiService->setResponse(
                new Fail($currencyException->getCustomMessage())
            );
        } catch (\Throwable $e) {
            $logger->warning($e->getMessage());
            $this->apiService->setResponse(
                new Fail($e->getMessage())
            );
        }

      //  echo($this->apiService->getResponse());
    }
}

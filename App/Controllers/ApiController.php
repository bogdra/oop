<?php


namespace App\Controllers;


use App\Entities\CommissionsCollection;
use \Core\Router;
use App\Traits\LoggingTrait;
use \App\Entities\Currency;
use \App\Entities\Commission;
use \App\Entities\Success;
use \App\Entities\Fail;
use \App\Entities\Error;
use \App\Services\CurrencyService;
use \App\Services\ECBCurrencyExchange;
use App\Exceptions\Request\FixedRouteElementsException;
use \App\Exceptions\Request\DifferenceBetweenValidationRuleAndParametersException;
use \App\Exceptions\Request\LengthMismatchBetweenRuleAndParameterException;
use App\Exceptions\Currency\CurrencyCharacterTypeInvalidException;
use App\Exceptions\Currency\CurrencyLengthInvalidException;
use App\Exceptions\Request\TypeMismatchBetweenRuleForParameterException;
use App\Exceptions\Currency\CurrencyNotInPermittedCurrenciesException;
use App\Exceptions\Currency\CurrencyCommissionRuleMustHaveThreeElementsException;
use App\Exceptions\Currency\CurrencyCommissionElementSmallerOrEqualToZeroException;
use App\Exceptions\Currency\CurrencyCommissionToValueSmallerThanFromValueException;


class ApiController extends Controller
{
    use LoggingTrait;


    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Route used is /api/convert/from/{currencyFrom}/to/{currencyTo}/value/{currencyValue}
     */
    public function convertAction(): void
    {
        try {
            $this->allowedRequestMethods('GET');
            Router::routeRuleValidation(func_get_args(), 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}');
            list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = func_get_args();

            $currencyService = new CurrencyService(
                new ECBCurrencyExchange());

            $commissions = $currencyService->getCommissions(
                new Currency(strtoupper($fromCurrency)),
                (int)$currencyValue
            );

            $rate = $currencyService->getExchangeRate(
                new Currency(strtoupper($fromCurrency)),
                new Currency(strtoupper($toCurrency))
            );

            echo(new Success([
                'CommissionRate' => $commissions['commissionPercentage'],
                'CommissionToPay' => $commissions['commissionToPay'],
                'ConvertedValue' => round((float)$currencyValue * $rate, 2),
                'ConversionRate' => $rate
            ]));

        } catch (
        CurrencyCommissionToValueSmallerThanFromValueException |
        CurrencyCommissionElementSmallerOrEqualToZeroException |
        CurrencyCommissionRuleMustHaveThreeElementsException
        $e
        ) {
            $this->logger->warning($e->getMessage());
            echo(new Fail($e->getCustomMessage()));
        } catch (
        DifferenceBetweenValidationRuleAndParametersException |
        LengthMismatchBetweenRuleAndParameterException |
        TypeMismatchBetweenRuleForParameterException |
        FixedRouteElementsException
        $e
        ) {
            $this->logger->warning($e->getMessage());
            echo(new Error($e->getCustomMessage()));
        } catch (\Throwable $e) {
            $this->logger->alert($e->getMessage());
            echo(new Fail($e->getMessage()));
        }
    }


    /*
    * Route used is /api/exchange/get/{currency}
    */
    public function exchangeAction(): void
    {
        try {
            $this->allowedRequestMethods('GET');
            Router::routeRuleValidation(func_get_args(), 'get/{alpha[3]}');
            list($get, $givenCurrency) = func_get_args();

            $currencyObj = new CurrencyService(new ECBCurrencyExchange);
            $response = $currencyObj
                ->generateCollectionForCurrency(new Currency($givenCurrency))
                ->formatCurrencyCollectionForApi();
            echo(new Success($response));

        } catch (
        CurrencyLengthInvalidException |
        CurrencyCharacterTypeInvalidException $e) {
            $this->logger->warning($e->getMessage());
            echo(new Fail($e->getCustomMessage()));
        } catch (\Throwable $e) {
            $this->logger->alert($e->getMessage());
            echo(new Fail($e->getMessage()));
        }
    }
}

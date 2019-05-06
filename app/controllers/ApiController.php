<?php

    namespace App\Controller;

    use App\Entities\Currency;
    use \App\Exception\CurrencyException;
    use \App\Exception\RequestException;
    use \App\Services\CurrencyService;
    use \App\Services\ApiService;
    use App\Services\ECBCurrencyExchange;
    use \Core\Router;

    class ApiController extends Controller
    {
        public $apiService;

        public function __construct()
        {
            parent::__construct();
            $this->apiService = new ApiService();
        }

        /*
         * Route used is /api/convert/from/{currencyFrom}/to/{currencyTo}/value/{currencyValue}
         */
        public function convertAction(): void
        {
            try {
                $this->allowedRequestMethods(['GET']);
                $params = func_get_args();
                Router::routeRuleValidation($params, 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}');
                list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = $params;

                $currencyService = new CurrencyService(new ECBCurrencyExchange());

                $rate = $currencyService->getExchangeRate(new Currency($fromCurrency), new Currency($toCurrency));
                $this->apiService->setResponse(
                    'success', [
                    'ConvertedValue' => round((float)$currencyValue * $rate, 2),
                    'ConversionRate' => $rate
                ]);
                print_r($this->apiService->jsonResponse());

            } catch (RequestException $requestException) {
                echo $requestException->getApiMessage();
            } catch (\Throwable $e) {
                echo $e->getMessage();
            }
        }

        /*
        * Route used is /api/exchange/get/{currency}
        */
        public function exchangeAction(): void
        {
            try {
                $this->allowedRequestMethods(['GET']);
                $params = func_get_args();
                Router::routeRuleValidation($params, 'get/{alpha[3]}');

                $currencyObj = new CurrencyService(new ECBCurrencyExchange);
               // var_dump($currencyObj);
                $response = $currencyObj
                    ->generateCollectionForCurrency(new Currency($params[1]))
                    ->formatCurrencyCollectionForApi();

                $this->apiService->setResponse('success', $response);
                print_r($this->apiService->jsonResponse());

            } catch (RequestException $requestException) {
                echo $requestException->getMessage();
            } catch (CurrencyException $currencyException) {
                echo $currencyException->getMessage();
            } catch (\Throwable $e) {
                echo $e->getMessage();
            }
        }
    }

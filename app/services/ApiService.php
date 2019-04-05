<?php
namespace App\Services;

use App\Exception\StatusCodeException;
use App\Exception\RequestException;
use App\Entities\ApiResponseEntity;
use mysql_xdevapi\Exception;

class ApiService
{
    private $response;

    public function __construct()
    {
    }

    public function setResponse($message, int $statusCode = 200)
    {
        $this->response = new ApiResponseEntity($message, $statusCode);
    }

    public function jsonResponse()
    {
        if (!headers_sent())
        {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");

            \http_response_code($this->response->getResponseCode());

            return json_encode([
                'status' => $this->response->getResponseCode(),
                'message' => $this->response->getMessage()
            ]);
        }
    }

    public function hasRightKeywordInRoute(array $params,string $keyword)
    {
        list($from, $fromCurrency, $to, $toCurrency, $value, $currencyValue) = $params;
        if (strtolower($$keyword) != $keyword)
        {
            throw new RequestException("The $keyword keyword is missing from the route");
        }
    }

    public function hasRightNumberOfParameters(array $params,int $numberOfParameters)
    {
        if (count($params) != $numberOfParameters)
        {
            throw new RequestException('The route contains the wrong number of parameters');
        }
    }


}
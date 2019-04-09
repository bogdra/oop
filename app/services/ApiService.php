<?php

namespace App\Services;

use App\Entities\ApiResponseEntity;

class ApiService
{
    private $response;

    public function setResponse($status, $data = '', $message = '')
    {
        $this->response = new ApiResponseEntity(\strtolower($status), $data, $message);
    }

    private function getResponse()
    {
        $response = [];
        switch (strtolower($this->response->getStatus())) {
            case 'success':
                $response = [
                    'status' => $this->response->getStatus(),
                    'data' => $this->response->getData()
                ];
                break;
            case 'fail':
                $response = [
                    'status' => $this->response->getStatus(),
                    'data' => $this->response->getMessage()
                ];
                break;
            case 'error':
                $response = [
                    'status' => $this->response->getStatus(),
                    'message' => $this->response->getMessage()
                ];
                break;
            default:
                throw new \Exception('The status code is not recognised.');
        }

        return $response;
    }

    public function jsonResponse()
    {
        if (!headers_sent()) {
            \header("Access-Control-Allow-Origin: *");
            \header("Content-Type: application/json; charset=UTF-8");
            \http_response_code(200);

            return json_encode($this->getResponse());
        }
        return 'Headers already sent';
    }


}
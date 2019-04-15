<?php

namespace App\Exception;

use App\Services\ErrorService;
use App\Services\ApiService;

class ViewException extends \Exception
{
    public function getCustomMessage()
    {
        ErrorService::setError($this->getMessage());
        return (DEBUG) ? 'Generic ' . get_class($this) . ' Error' : $this->getMessage();
    }

    public function getApiMessage()
    {
        $apiService = new ApiService();
        $apiService->setResponse('fail', '', $this->getCustomMessage());
        return $apiService->jsonResponse();
    }
}
<?php

namespace App\Exception;

use \App\Traits\DebugException;
use \App\Services\ErrorService;

class RequestException extends \Exception
{
    public function getCustomMessage()
    {
        ErrorService::setError($this->getMessage());
        if (DEBUG) {
            return ('Generic ' . get_class($this) . ' Error');
        }
        return $this->getMessage();
    }

    public function getApiMessage()
    {
        ErrorService::setError($this->getMessage());
        $message = (DEBUG) ? 'There was a problem with the request' : $this->getMessage();

        $apiService =  new \App\Services\ApiService();
        $apiService->setResponse('fail', '', $message );
        return $apiService->jsonResponse();
    }
}

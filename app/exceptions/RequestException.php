<?php

namespace App\Exception;

use \App\Traits\DebugException;
use \App\Services\ErrorService;

class RequestException extends \Exception
{
    public function getCustomMessage()
    {
        ErrorService::setError($this->getMesage());
        if (DEBUG) {
            return ('Generic ' . get_class($this) . ' Error');
        }
        return $this->getMessage();
    }
}

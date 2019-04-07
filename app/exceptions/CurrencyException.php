<?php

namespace App\Exception;

use \App\Services\ErrorService;

class CurrencyException extends \Exception
{
    public function getCustomMessage()
    {
        ErrorService::setError($this->getMessage());
        if (DEBUG) {
            return ('Generic ' . get_class($this) . ' Error');
        }
        return $this->getMessage();
    }
}

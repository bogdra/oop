<?php

namespace App\Exception;

use \App\Services\ErrorService;

class FileException extends \Exception
{
    public function customGetMessage()
    {
        ErrorService::setError($this->getMessage());
        if (DEBUG) {
            return ('Generic ' . get_class($this) . ' Error');
        }
        return $this->getMessage();
    }
}
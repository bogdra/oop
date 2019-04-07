<?php

namespace App\Exception;

class StatusCodeException extends \Exception
{
    public function customGetMessage()
    {
        if (DEBUG) {
            return ('Generic ' . get_class($this) . ' Error');
        }
        return $this->getMessage();
    }
}
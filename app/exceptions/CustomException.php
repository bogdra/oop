<?php

namespace App\Exception;

class CustomException extends \Exception
{
    public function getCustomMessage()
    {
        return (DEBUG) ? 'Generic ' . get_class($this) . ' Error' : $this->getMessage();
    }
}
<?php

namespace App\Exceptions;

class CustomException extends \Exception
{
    public function getCustomMessage()
    {
        return (DEBUG) ?  $this->getMessage() : 'Generic ' . substr(strrchr(__CLASS__, "\\"), 1) . ' Error' ;
    }
}
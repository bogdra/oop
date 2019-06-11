<?php


namespace App\Exceptions;


use Throwable;
use Core\Helper;

class CustomException extends \Exception
{
    private $className;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->className =  substr(get_class($this), strrpos(get_class($this), '\\') + 1)  ;
    }

    public function getCustomMessage()
    {
        return (DEBUG) ?
            $this->getMessage() :
            Helper::splitCamelCaseString($this->className);
    }


}
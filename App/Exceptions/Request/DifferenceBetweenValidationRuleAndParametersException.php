<?php


namespace App\Exceptions\Request;


use App\Exceptions\CustomException;


class DifferenceBetweenValidationRuleAndParametersException extends CustomException
{
    public function getFriendlyMessage()
    {
        return 'Route problem. The number of parameter do not match with any defined route.';
    }
}
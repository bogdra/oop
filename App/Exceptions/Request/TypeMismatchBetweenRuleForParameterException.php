<?php


namespace App\Exceptions\Request;


use App\Exceptions\CustomException;


class TypeMismatchBetweenRuleForParameterException extends CustomException
{
    public function getFriendlyMessage()
    {
        return 'Route problem. One of the parameter does not conform to the type set in the rule.';
    }
}
<?php


namespace App\Exceptions\Request;


use App\Exceptions\CustomException;


class FixedRouteElementsException extends CustomException
{
    public function getFriendlyMessage()
    {
        return 'Route problem. The route is not quite correct. Take a closer look and fix it.';
    }
}
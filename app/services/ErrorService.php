<?php

namespace App\Services;

class ErrorService
{
    private static $errors = [];

    public static function setError(string $message)
    {
        array_push(self::$errors, $message);
    }

    public static function getErrors()
    {
        return self::$errors;
    }

    public function getErrorsCount()
    {
        return count(self::$errors);
    }
}
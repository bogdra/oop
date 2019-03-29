<?php

namespace Core;

/**
 * Class H
 * @package Core
 * @desc Helper class that contains different helper functions
 */
class H
{
    /**
     * @param $variable
     * @param string $variableName
     */
    public static function dnl($variable, $variableName = '')
    {
        echo('<pre style="border:1px solid #bbba74">');
        if ($variableName != '')
        {
            echo('<b>'.$variableName.'</b> is  ');
        }
        \print_r($variable);
        echo('</pre>');
    }

    /**
     * @param $variable
     * @param string $variableName
     */
    public static function dnd($variable, $variableName = '')
    {
        self::dnl($variable, $variableName);
        die();
    }

}
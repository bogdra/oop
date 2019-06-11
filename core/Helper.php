<?php

namespace Core;

/**
 * Class H
 * @package Core
 * @desc Helper class that contains different helper functions
 */
class Helper
{
    /**
     * @param $variable
     * @param string $variableName
     */
    public static function dnl($variable, $variableName = '')
    {
        echo('<pre style="border:1px solid #bbba74">');
        if ($variableName != '') {
            echo('<b>' . $variableName . '</b> is  ');
        }
        \print_r($variable);
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

    /**
     * Checks with get_headers that the file exists
     * @param string $fileUrl
     * @return bool
     */
    public static function remoteFileExists(string $fileUrl): bool
    {
        $headersArray = get_headers($fileUrl);
        if (substr($headersArray[0], 9, 3) != '200') {
            return false;
        }
        return true;
    }


    public static function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    public static function splitCamelCaseString(string $string): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $string);
        $buffer = '';
        foreach ($pieces as $piece) {
            $buffer .= $piece. ' ';
        }
        return rtrim($buffer);
    }
}



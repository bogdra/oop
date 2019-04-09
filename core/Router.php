<?php

namespace Core;

use App\Exception\RequestException;

class Router
{
    private static $controller;
    private static $action;

    /**
     * Router method to call the right conntroller / action
     *
     * @param array $urlElements
     */
    public static function route(array $urlElements)
    {
        $tempController = (isset($urlElements[0]) && $urlElements[0] != '') ? \ucfirst($urlElements[0]) . 'Controller' : DEFAULT_CONTROLLER . 'Controller';
        self::$controller = 'App\Controller\\' . $tempController;


        self::$action = (isset($urlElements[1]) && $urlElements[1] != '') ? \lcfirst($urlElements[1]) . 'Action' : DEFAULT_ACTION . 'Action';

        //TODO: needs rewrite
        if (\count($urlElements) > 2) {
            for ($i = 2; $i < \count($urlElements); $i++) {
                if ($urlElements[$i] != '') {
                    $params[] = $urlElements[$i];
                }
            }
        } else {
            $params = [];
        }

        (self::checkControllerAndActionExists()) ?
            call_user_func_array([new self::$controller, self::$action], $params) :
            self::redirect('Restricted/');
    }

    /**
     * Checks if the controller file exists and if so if the action required exists
     *
     * @return bool
     */
    public static function checkControllerAndActionExists()
    {
        if (class_exists(self::$controller)) {
            $tempObject = new self::$controller;
            if (method_exists($tempObject, self::$action)) {
                return true;
            }
            unset ($tempObject);
        }
        return false;
    }

    /**
     * Redirect the user to a specific page
     *
     * @param string $location
     * @param int $status
     */
    public static function redirect(string $location, int $status = 301)
    {
        if (!headers_sent()) {
            http_response_code($status);
            header('Location: ' . URL_ROOT . $location);
            exit();
        }
        die('Header already sent. Killed execution');
    }

    public static function routeRuleValidation(array $params, string $routeRule)
    {
        //$routeRule = 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}';
        $regexRule = "/{(.*?(\[\d\])?)}/mi";

        $ruleArray = explode('/', $routeRule);

        //compares the rule number of elements with the provided number of params
        if (count($ruleArray) != count($params)) {
            throw new RequestException('Mismatch between rule and current number of parameters');
        }

        for ($i = 0; $i < count($ruleArray); $i++) {
            //if the elem in the RuleArray is a variable
            if (preg_match($regexRule, $ruleArray[$i], $matches, PREG_OFFSET_CAPTURE) == 1) {
                // extract the type of variable
                if (isset($matches[1])) {
                    $explodedTypeMatch = explode('[', $matches[1][0]);
                    $type = $explodedTypeMatch[0];
                }
                //extract the length if is set
                if (isset($matches[2])) {
                    $explodedLengthMatch = explode('[', $matches[2][0]);
                    $explodedLengthMatch = explode(']', $explodedLengthMatch[1]);
                    $length = (int)$explodedLengthMatch[0];
                } else {
                    $length = 0;
                }

                //check if the variable param is of the type declared in the rule
                if (!call_user_func('ctype_' . $type, $params[$i])) {
                    throw new RequestException('Url parameter ' . $params[$i] . ' needs to be formed from ' . $type . ' characters');
                }

                //check if the length is set in the rule for the current route parameter
                if (isset($length) && $length > 0) {
                    // if so , check if the parameter's length is equal if the one set in the rule
                    if (strlen($params[$i]) != $length) {
                        throw new RequestException('The length of ' . $params[$i] . ' is not correct');
                    }
                }
            } //if the static elements of the route are not as agreed in the rule
            elseif (strtolower($ruleArray[$i]) != strtolower($params[$i])) {
                throw new RequestException('Malformed Route. The route does not obey the set rule.');

            }
        }
    }
}

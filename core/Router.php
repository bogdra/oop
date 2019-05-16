<?php


namespace Core;


use App\Exceptions\HeadersAlreadySentException;
use App\Exceptions\DifferenceBetweenValidationRuleAndParametersException;
use App\Exceptions\TypeMismatchBetweenRuleForParameterException;
use App\Exceptions\LengthMismatchBetweenRuleAndParameterException;
use App\Exceptions\FixedRouteElementsException;


class Router
{
    private static $controller;
    private static $action;


    public static function route(array $urlElements)
    {
        try {
            $controller = (isset($urlElements[0]) && $urlElements[0] != '') ? \ucfirst($urlElements[0]) . 'Controller' : DEFAULT_CONTROLLER . 'Controller';
            self::$controller = 'App\Controllers\\' . $controller;

            self::$action = (isset($urlElements[1]) && $urlElements[1] != '') ? \lcfirst($urlElements[1]) . 'Action' : DEFAULT_ACTION . 'Action';

            //TODO: needs rewrite
            $params = [];

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
        } catch (HeadersAlreadySentException $e) {
            throw $e;
        }
    }


    public static function checkControllerAndActionExists(): bool
    {
        if (\class_exists(self::$controller)) {
            $tempObject = new self::$controller;
            if (\method_exists($tempObject, self::$action)) {
                return true;
            }
            unset ($tempObject);
        }
        return false;
    }


    public static function redirect(string $location, int $status = 301)
    {
        if (!\headers_sent()) {
            \http_response_code($status);
            \header('Location: ' . URL_ROOT . $location);
            exit();
        }
        throw new HeadersAlreadySentException('The headers have already been sent.');
    }


    public static function routeRuleValidation(array $params, string $routeRule)
    {
        //$routeRule = 'from/{alpha[3]}/to/{alpha[3]}/value/{digit}';
        $regexRule = "/{(.*?(\[\d\])?)}/mi";

        $arrayOfRuleElements = \explode('/', $routeRule);

        //compares the rule number of elements with the provided number of params
        if (\count($arrayOfRuleElements) != \count($params)) {
            throw new DifferenceBetweenValidationRuleAndParametersException
            ('Mismatch between the validation rule and number of parameters given to the controller');
        }

        for ($i = 0; $i < count($arrayOfRuleElements); $i++) {
            //if the elem in the RuleArray is a variable
            if (\preg_match($regexRule, $arrayOfRuleElements[$i], $matches, PREG_OFFSET_CAPTURE) == 1) {

                list($type, $length) = self::extractRuleTypeAndLength($matches);

                //check if the variable param is of the type declared in the rule
                if (!\call_user_func('ctype_' . $type, $params[$i])) {
                    throw new TypeMismatchBetweenRuleForParameterException
                    ('Url parameter ' . $params[$i] . ' needs to be formed from ' . $type . ' characters.');
                }

                //check if the length is set in the rule for the current route parameter
                if (isset($length) && $length > 0) {
                    // if so, check if the parameter's length is equal if the one set in the rule
                    if (\strlen($params[$i]) != $length) {
                        throw new LengthMismatchBetweenRuleAndParameterException
                        ('The length of ' . $params[$i] . ' is not correct');
                    }
                }
            } //if the fixed elements of the route are not as agreed in the rule
            elseif (\strtolower($arrayOfRuleElements[$i]) !== \strtolower($params[$i])) {
                throw new FixedRouteElementsException
                ('Malformed route. The route does not conform the set rule.');

            }
        }
    }

    /**
     * returns an array with rule and length
     */
    private static function extractRuleTypeAndLength($matches): array
    {
        // extract the type of variable
        if (isset($matches[1])) {
            $type = (\explode('[', $matches[1][0]))[0];
        }
        //extract the length if is set
        if (isset($matches[2])) {
            $length = (int)Helper::get_string_between($matches[2][0], '[', ']');
        } else {
            $length = 0;
        }

        return [$type, $length];
    }
}

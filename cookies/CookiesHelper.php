<?php
include_once "../filters/php/Filter.php";

class CookiesHelper
{
    public static function setCookieFilter($filter) {
        setCookie($filter->getCookieName(), $filter->getEncoded());
    }

    public static function setCookie($name, $value) {
        setcookie($name, $value);
    }

    public static function getCookieFilter($cookieName, $class): ?Filter {
        if (isset($_COOKIE[$cookieName])) {
//            echo("Cookie string: " . $_COOKIE[$cookieName]. "<br/>");
            $string = urldecode($_COOKIE[$cookieName]);
//            echo("URL decoded: " . $string . "<br/>");
            return $class::from(json_decode($string));
        }
        return null;
    }
}
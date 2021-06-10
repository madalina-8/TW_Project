<?php
foreach (glob("../filters/php/*.php") as $filename)
{
    include_once $filename;
}
include_once "../cookies/CookiesHelper.php";

//when changing 'formNames' change its value in script.js too

$formNames = array("year", "region", "country", "sex", "chartType");

function getShareLink() {
    global $formNames;
    $data = array();
    foreach ($formNames as $name) {
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            $data[$name] = $value;
        }
    }
    return http_build_query($data);
}

function addCookie($name, $value) {
    setcookie($name, $value);
}

function filterFromPost($name): ?Filter {
    $values = $_POST[$name];
    $array = explode(',', $values);
    //var_dump($array);
    echo("<br/>");
    switch ($name) {
        case YearFilter::getCookieName():
            return new YearFilter($array);

        case SexFilter::getCookieName():
            return new SexFilter($array);

        case CountryFilter::getCookieName():
            return new CountryFilter($array);

        case RegionFilter::getCookieName():
            return new RegionFilter($array);

        case ChartFilter::getCookieName():
            return new ChartFilter($array);

        default:
            return null;
    }
}

function submitForm() {
    global $formNames;
    var_dump($_POST);
    foreach ($formNames as $name) {
        if (isset($_POST[$name])) {
            $filter = filterFromPost($name);
            //var_dump($filter);
            if ($filter != null) {
                echo("Filter to put in cookie:" . $filter->getEncoded() . "<br/>");
                CookiesHelper::setCookieFilter($filter);
            }
        }
    }

    header("Location: ./home.php");
}

function checkGETAndRedirect() {
    global $formNames;

    $shouldExit = false;

    foreach ($formNames as $name) {
        if (isset($_GET[$name])) {
            $value = $_GET[$name];
            addCookie($name, $value);
            $shouldExit = true;
        }
    }

    return $shouldExit;
}
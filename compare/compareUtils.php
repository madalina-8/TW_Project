<?php
foreach (glob("../filters/php/*.php") as $filename)
{
    include_once $filename;
}
include_once "../cookies/CookiesHelper.php";

//when changing 'formNames' change its value in scriptCompare.js too
$formNames = array("year", "region", "country", "sex");
$yearFilter = new YearFilter([], false);
$regionFilter = null;
$countryFilter = null;
$sexFilter = null;

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

function submitForm() {
    global $formNames;
    foreach ($formNames as $name) {
        if (isset($_POST[$name])) {
            $filter = filterFromPost($name);
            if ($filter != null) {
                echo("Filter to put in cookie:" . $filter->getEncoded() . "<br/>");
                CookiesHelper::setCookieFilter($filter);
            }
        }
    }

    header("Location: ./compare.php");
}

function filterFromPost($name): ?Filter {
    $values = $_POST[$name];
    $array = explode(',', $values);
    echo("Array: ");
    var_dump($array);
    echo("<br/>");
    switch ($name) {
        case YearFilter::getCookieName():
            return new YearFilter($array);
            break;
        case SexFilter::getCookieName():
            return new SexFilter($array);
            break;
        case CountryFilter::getCookieName():
            return new CountryFilter($array);
            break;
        case RegionFilter::getCookieName():
            return new RegionFilter($array);
            break;
        default:
            return null;
    }
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

function importFiltersFromCookies() {
    global $yearFilter, $sexFilter, $regionFilter, $countryFilter;
    $yearFilter = CookiesHelper::getCookieFilter(YearFilter::getCookieName(), YearFilter::class);
    $sexFilter = CookiesHelper::getCookieFilter(SexFilter::getCookieName(), SexFilter::class);
    $regionFilter = CookiesHelper::getCookieFilter(RegionFilter::getCookieName(), RegionFilter::class);
    $countryFilter = CookiesHelper::getCookieFilter(CountryFilter::getCookieName(), CountryFilter::class);
}

function generateCompareTable() {
    global $yearFilter, $sexFilter, $regionFilter, $countryFilter;




}
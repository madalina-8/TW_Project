<?php
foreach (glob("filters/php/*.php") as $filename)
{
    include_once $filename;
}
include_once "cookies/CookiesHelper.php";

//when changing 'formNames' change its value in script.js too
$formNames = array("yearSelections", "regionSelections", "countrySelections", "sexSelections");

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

function submitForm() {
    echo("================================================================================================");
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
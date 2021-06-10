<?php
foreach (glob("../filters/php/*.php") as $filename)
{
    include_once $filename;
}
include_once "../cookies/CookiesHelper.php";

//when changing 'formNames' change its value in scriptCompare.js too
$formNames = array("year", "region", "country", "sex", "chartType");
$yearFilter = null;
$regionFilter = null;
$countryFilter = null;
$sexFilter = null;
$groupedId = "grouped";
$cookies = array_merge($formNames, [$groupedId]);

function getFilters(): array {
    global $yearFilter, $sexFilter, $regionFilter, $countryFilter;
    return [$yearFilter, $sexFilter, $countryFilter, $regionFilter];
}

function getShareLink() {
    global $cookies;
    $data = array();
    foreach ($cookies as $name) {
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            $data[$name] = $value;
        }
    }
    return urlencode(http_build_query($data));
}

function addCookie($name, $value) {
    setcookie($name, $value);
}

function submitForm() {
    global $formNames, $groupedId;
    foreach ($formNames as $name) {
        if (isset($_POST[$name])) {
            $filter = filterFromPost($name);
            if ($filter != null) {
                echo("Filter to put in cookie:" . $filter->getEncoded() . "<br/>");
                CookiesHelper::setCookieFilter($filter);
            }
        }
    }

    if (isset($_POST[$groupedId])) {
        CookiesHelper::setCookie($groupedId, $_POST[$groupedId]);
    } else {
        CookiesHelper::setCookie($groupedId, "off");
    }

    header("Location: ./compare.php");
}

function filterFromPost($name): ?Filter {
    $values = $_POST[$name];
    $compare = $_POST[$name . "Compare"] == "on";
    return filterFromData($name, $values, $compare);
}

function filterFromData($name, $values, $compare) {
    $array = explode(',', $values);
    if (strlen(trim($values)) == 0)
        $array = [];
    echo("Array: ");
//    var_dump($compare);
    echo("<br/>");
    switch ($name) {
        case YearFilter::getCookieName():
            return new YearFilter($array, $compare);
            break;
        case SexFilter::getCookieName():
            return new SexFilter($array, $compare);
            break;
        case CountryFilter::getCookieName():
            return new CountryFilter($array, $compare);
            break;
        case RegionFilter::getCookieName():
            return new RegionFilter($array, $compare);
            break;
        default:
            return null;
    }
}

function checkGETAndRedirect(): bool{
    global $cookies;
//    var_dump($cookies);

    $shouldExit = false;

    foreach ($cookies as $name) {
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

function shouldCompare($filter): bool {
    return $filter->shouldCompare();
}

function shouldNotCompare($filter): bool
{
    return !$filter->shouldCompare();
}

function generateCompareTable() {
    $compareFilters = getCompareFilters();
    $normalFilters = getFiltersWithout($compareFilters);
    if (count($compareFilters) > 0) {
        echo "<table>";

        echo "<tr>";

        echo "<th>";
        echo $compareFilters[0]->getCookieName();
        if (count($compareFilters) > 1) {
            echo "<br/>" . $compareFilters[1]->getCookieName();
        }
        echo "</th>";

        foreach($compareFilters[0]->getValues() as $value) {
            echo "<th>" . $value . "</th>";
        }
        echo "</tr>";

        if (count($compareFilters) > 1) {
            foreach($compareFilters[1]->getValues() as $second) {
                echo "<tr>";
                echo "<th>" . $second . "</th>";
                foreach($compareFilters[0]->getValues() as $first) {
                    echo "<td>";

                    $onlyFirst = clone $compareFilters[0];
                    $onlyFirst->setValues([$first]);

                    $onlySecond = clone $compareFilters[1];
                    $onlySecond->setValues([$second]);


                    printCanvasForFilters(array_merge($normalFilters, [$onlySecond, $onlyFirst]));

                    echo "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td></td>";
            foreach($compareFilters[0]->getValues() as $value) {
                echo "<td>";

                $onlyFirst = clone $compareFilters[0];
                $onlyFirst->setValues([$value]);

                printCanvasForFilters(array_merge($normalFilters, [$onlyFirst]));

                echo "</td>";
            }
            echo "</tr>";

        }
        echo "</table>";
    } else {
        printCanvasForFilters($normalFilters);
    }
}

function getCompareFilters(): array
{
    $filters = getFilters();
    $result = [];
    foreach($filters as $filter) {
        if (shouldCompare($filter))
            $result[] = $filter;
        if (count($result) > 1)
            break;
    }
    return $result;
}

function getFiltersWithout($without): array
{
    $filters = getFilters();
    $result = [];
    foreach($filters as $filter) {
        if (!in_array($filter, $without))
            $result[] = $filter;
    }
    return $result;
}

function orderFilters($filters): array {
    $result = [];
    foreach($filters as $filter) {
        switch ($filter->getCookieName()) {
            case "region": $result[0] = $filter;
                break;
            case "country": $result[1] = $filter;
                break;
            case "year": $result[2] = $filter;
                break;
            case "sex": $result[3] = $filter;
                break;
            default: echo "Unknown filter: " . $filter->getCookieName();
        }
    }
    ksort($result);
    return $result;
}

function printCanvasForFilters($filters) {
//    var_dump($filters);
    $ordered = orderFilters($filters);
//    echo "<br/><br/><br/> ";
//    var_dump($ordered);
    $id = rand();
    echo "<canvas id=\"" . $id . "\">";

//    echo "<script  type=\"module\">\n";
//
//    echo "import CookiesHelper from \"../cookies/CookiesHelper.js\";\n";

    echo "<script type='module'>\n";
    echo "import { viewHandler } from './compareChart.js'\n";
    foreach($ordered as $filter) {
        echo "let " . $filter->getCookieName() . " = \"" . str_replace("\"", "\\\"", $filter->getEncoded()) . "\" \n";
    }

    foreach($ordered as $filter) {
        echo "let " .
            $filter->getCookieName() . "Filter = " .
            "JSON.parse(" .
            $filter->getCookieName() .")  \n";
    }

    echo "viewHandler.generateChart(" . $id;

    foreach($ordered as $filter) {
        echo ", " . $filter->getCookieName() . "Filter.values";
    };

    echo ",\"bar\")\n";

    echo "</script>";

    echo "</canvas>";
}
//
//importFiltersFromCookies();
//generateCompareTable();

//function getCompareFilters(): array
//{
//    foreach ($filters as $first) {
//        if ($first->shouldCompare()) {
//            foreach($filters as $second) {
//                if ($second != $first && $second->shouldCompare()) {
//                    return [$first,$second];
//                }
//            }
//            return [$first];
//        }
//    }
//    return null | null;
//}
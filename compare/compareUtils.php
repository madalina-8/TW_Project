<?php
foreach (glob("../filters/php/*.php") as $filename)
{
    include_once $filename;
}
include_once "../cookies/CookiesHelper.php";

//when changing 'formNames' change its value in scriptCompare.js too
$formNames = array("year", "region", "country", "sex");
$yearFilter = null;
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
    $compare = $_POST[$name . "Compare"] == "on";
    $array = explode(',', $values);
    echo("Array: ");
    var_dump($compare);
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

function shouldCompare($filter): bool {
    return $filter->shouldCompare();
}

function shouldNotCompare($filter): bool
{
    return !$filter->shouldCompare();
}

function generateCompareTable() {
    $compareFilters = getCompareFilters();
    $normalFilters = getNormalFilters();
//    var_dump($compareFilters);
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


                    showCanvasForFilters(array_merge($normalFilters, [$onlySecond, $onlyFirst]));

                    echo "</td>";
                }
                echo "</tr>";
            }
        } else {
        }


        echo "</table>";
    } else {

    }
}

function getCompareFilters(): array
{
    global $yearFilter, $sexFilter, $regionFilter, $countryFilter;
    $filters = [$sexFilter,$yearFilter, $regionFilter, $countryFilter];
    $result = [];
    foreach($filters as $filter) {
        if (shouldCompare($filter))
            $result[] = $filter;
    }
    return $result;
}

function getNormalFilters(): array
{
    global $yearFilter, $sexFilter, $regionFilter, $countryFilter;
    $filters = [$sexFilter,$yearFilter, $regionFilter, $countryFilter];
    $result = [];
    foreach($filters as $filter) {
        if (shouldNotCompare($filter))
            $result[] = $filter;
    }
    return $result;
}

function showCanvasForFilters($filters) {
    $id = rand();
    echo "<canvas id=\"" . $id . "\">";

    echo "<script  type=\"module\">";

    echo "import CookiesHelper from \"../cookies/CookiesHelper.js\";";

    foreach($filters as $filter) {
        echo "let " . $filter->getCookieName() . " = \"" . str_replace("\"", "\\\"", $filter->getEncoded()) . "\" \n";
    }

    foreach($filters as $filter) {
        echo "let " .
            $filter->getCookieName() . "Filter = " .
            "CookiesHelper.getCookieFilter(" .
            $filter->getCookieName() .")  \n";
    }

    echo "let filters = [" . $filters[0]->getCookieName();
    foreach(array_splice($filters, 1) as $filter) {
        echo ", " . $filter->getCookieName() . "Filter";
    }
    echo "]\n";

    echo "viewHandler.generateChart(" . $id . ", filters)\n";




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
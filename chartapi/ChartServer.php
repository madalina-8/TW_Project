<?php
$region = $_GET['sRegion'];
$country = $_GET['sCountry'];
$year = $_GET['sYear'];
$sex = $_GET['sSex'];

$region = str_replace(", ", "','", $region);
$country = str_replace(", ", "','", $country);
$year = str_replace(", ", "','", $year);
$sex = str_replace(", ", "','", $sex);

$mysqli = new mysqli("localhost","root","","project") or die(mysqli_error($mysqli));

$countries = "'$country'";
$years = "'$year'";
$sexes = "'$sex'";
$regions = "'$region'";

$customQuery = "SELECT * FROM data WHERE ";
$needsAnd = false;
if(strlen($country) > 0) {
    $customQuery = $customQuery."Country IN ($countries)";
    $needsAnd = true;
}
if(strlen($year) > 0) {
    if($needsAnd) {
        $customQuery = $customQuery." AND ";
    }
    $customQuery = $customQuery."Year IN ($years)";
    $needsAnd = true;
}

if(strlen($sex) > 0) {
    if($needsAnd) {
        $customQuery = $customQuery." AND ";
    }
    $customQuery = $customQuery."Sex IN ($sexes)";
    $needsAnd = true;
}

if(strlen($region) > 0) {
    if($needsAnd) {
        $customQuery = $customQuery." AND ";
    }
    $customQuery = $customQuery."Location IN ($regions)";
}

if($customQuery == "SELECT * FROM data WHERE ")
    $customQuery = "SELECT * FROM data";

$search_c = $mysqli->query($customQuery) or die($mysqli->error);

while($row = $search_c->fetch_array()):
    $data = $row['Location'].','.$row['Country'].','.$row['Year'].','.$row['Sex'].','.$row['Value'];
    echo json_encode($data);
    echo "|";
endwhile;
?>

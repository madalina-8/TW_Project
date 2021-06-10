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

$search_c = $mysqli->query("SELECT * FROM data WHERE Country IN ($countries) AND Year IN ($years) AND Sex IN ($sexes) AND Location IN ($regions)") or die($mysqli->error);
while($row = $search_c->fetch_array()):
    $data = $row['Location'].','.$row['Country'].','.$row['Year'].','.$row['Sex'].','.$row['Value'];
    echo json_encode($data);
    echo "|";
endwhile;
?>

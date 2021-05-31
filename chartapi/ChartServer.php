<?php
class ChartServer
{
    public  function __construct() {
        $region = $_GET['sRegion'];
        $country = $_GET['sCountry'];
        $year = $_GET['sYear'];
        $sex = $_GET['sSex'];
        echo "$region$country$year$sex";
    }
}
$chartServer = new ChartServer();
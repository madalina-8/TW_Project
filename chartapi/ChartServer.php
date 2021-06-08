<?php
class ChartServer
{
    private $columnRegion = 0;
    private $columnCountry = 1;
    private $columnYear = 2;
    private $columnSex = 3;
    private $columnValue = 4;

    public function __construct() {
        $region = $_GET['sRegion'];
        $country = $_GET['sCountry'];
        $year = $_GET['sYear'];
        $sex = $_GET['sSex'];
        echo "$region$country$year$sex"
            . $this->getFields(["Ooga", "Booga", "Chunga", "Wonga"])
            . $this->getData($region,$country, $year, $sex);
    }

    public function isSelectableData(
        $cols,
        $sRegion,
        $Country,
        $sYear,
        $sSex
    ): bool
    {
        return (in_array($cols[$this->columnRegion], $sRegion) || count($sRegion) == 0) &&
            (in_array($cols[$this->columnCountry], $Country) || count($Country) == 0) &&
            (in_array($cols[$this->columnYear], $sYear) || count($sYear) == 0) &&
            (in_array($cols[$this->columnSex], $sSex) || count($sSex) == 0);
    }

    public function getFields($cols): string {
        $fieldsToGet = [$this->columnCountry, $this->columnYear, $this->columnSex];
        $concatenatedValue = "";
        foreach ($fieldsToGet as $field) {
            $concatenatedValue = $concatenatedValue . $cols[$field];
        }
        return $concatenatedValue;
    }

    public function getData(
        $sRegion,
        $sCountry,
        $sYear,
        $sSex
    ): string {
        $someString = "";
        if (($handle = fopen('data.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                for ($i = 0; $i < count($data); $i++) {
                    $someString = $someString . $data[$i];
                }
            }
            fclose($handle);
        }
        return $someString;
    }
}
$chartServer = new ChartServer();
?>
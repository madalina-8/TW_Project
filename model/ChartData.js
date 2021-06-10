export default class ChartData {
    constructor() {
        // The order in the csv files is as stands:
        // Location___Country___Year___Sex___Value
        // 0          1         2      3     4
        this.selectedRegion = [""] // getCookie for list
        this.selectedCountry = [""] // getCookie for list
        this.selectedYear = [""] // getCookie for list
        this.selectedSex = [""] // getCookie for list
        this.defaultValue = ["-"]

        this.columnRegion = 0
        this.columnCountry = 1
        this.columnYear = 2
        this.columnSex = 3
        this.columnValue = 4

        this.idRegion = "region1"
        this.idCountry = "country1"
        this.idYear = "year1"
        this.idSex = "sex1"

        this.idSelectedRegion = "region"
        this.idSelectedCountry = "country"
        this.idSelectedYear = "year"
        this.idSelectedSex = "sex"
    }
}
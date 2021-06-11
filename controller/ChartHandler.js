export default class ChartHandler {
    constructor(chartData) {
        this.chartData = chartData
    }

    async getData(sRegion,
                  sCountry,
                  sYear,
                  sSex
    ) {
        /*
        const response = await fetch("data.csv");
        const data = await response.text();
        const rows = data.split('\n').slice(1);
        const entryName = [];
        const entryValue = [];
        rows.forEach(row => {
            const cols = row.split(',');
            if(this.isSelectableData(cols, sRegion, sCountry, sYear, sSex)) {
                entryName.push(this.getFields(cols));
                entryValue.push(parseFloat(cols[4]));
            }
        });
        const isGrouped = document.getElementById("grouped")?.checked

        if (isGrouped === true) {
            return {enName: ["Average"], enValue: [this.getAverage(entryValue)]}
        } else {
            return {enName: entryName, enValue: entryValue};
        }
        */
        let url = new URL('http://localhost:63342/TW_Project/chartapi/ChartServer.php')
        let params = {
            sRegion: sRegion,
            sCountry: sCountry,
            sYear: sYear,
            sSex: sSex
        }
        console.log(params)
        url.search = new URLSearchParams(params).toString()
        console.log(url)
        let response = await fetch(url, {
            method: 'GET',
        });
        const data = await response.text()
        console.log(data)
        const entries = data.split('|')
        entries.splice(entries.length-1)
        const entryName = [];
        const entryValue = [];
        entries.forEach(entry => {
            const en = entry.replaceAll("\"", "").split(',')
            entryName.push(this.getFields(en));
            entryValue.push(parseFloat(en[4]));
        })

        const isGrouped = document.getElementById("grouped")?.checked

        if (isGrouped === true) {
            return {enName: ["Average"], enValue: [this.getAverage(entryValue)]}
        } else {
            return {enName: entryName, enValue: entryValue};
        }
    }

    getAverage(array) {
        const sum = array.reduce((a, b) => a + b, 0);
        return (sum / array.length) || 0;
    }

    getFields(cols) {
        let fieldsToGet = [this.chartData.columnCountry, this.chartData.columnYear, this.chartData.columnSex]
        let concatenatedValue = ""
        fieldsToGet.forEach(field => {
            if(concatenatedValue !== "")
                concatenatedValue += ", "
            concatenatedValue = concatenatedValue + cols[field]
        })
        return concatenatedValue
    }

    updateField(
        fieldColumn,
        optionsID
    ) {
        let options = document.querySelector('#' + optionsID)
        switch(fieldColumn) {
            case this.chartData.columnRegion:
                this.chartData.selectedRegion = options.valueOf().value
                break;
            case this.chartData.columnCountry:
                this.chartData.selectedCountry = options.valueOf().value
                break;
            case this.chartData.columnYear:
                this.chartData.selectedYear = options.valueOf().value
                break;
            case this.chartData.columnSex:
                this.chartData.selectedSex = options.valueOf().value
                break;
            default:
                console.log("???")
        }
    }

    RemoveDuplicates(arr) {
        let s = new Set(arr);
        let it = s.values();
        return Array.from(it);
    }

    filter() {
        this.updateField(this.chartData.columnRegion, this.chartData.idSelectedRegion)
        this.updateField(this.chartData.columnCountry, this.chartData.idSelectedCountry)
        this.updateField(this.chartData.columnYear, this.chartData.idSelectedYear)
        this.updateField(this.chartData.columnSex, this.chartData.idSelectedSex)
    }

    isSelectableData(cols,
                     sRegion,
                     sCountry,
                     sYear,
                     sSex
    ) {
        return (sRegion.includes(cols[this.chartData.columnRegion]) || this.isArrayEmpty(sRegion)) &&
            (sCountry.includes(cols[this.chartData.columnCountry]) || this.isArrayEmpty(sCountry)) &&
            (sYear.includes(cols[this.chartData.columnYear]) || this.isArrayEmpty(sYear)) &&
            (sSex.includes(cols[this.chartData.columnSex]) || this.isArrayEmpty(sSex));
    }
    isArrayEmpty(array) {
        /*if(array.length === 0) {
            return true
        }
        let empty = true
        array.forEach(element => {
            if(element !== "" && element !== this.chartData.defaultValue) {
                empty = false
            }
        })
        return empty;*/
        return array === "" || array === this.chartData.defaultValue
    }
}
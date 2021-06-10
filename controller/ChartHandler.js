export default class ChartHandler {
    constructor(chartData) {
        this.chartData = chartData
    }

    async getData(sRegion,
                  sCountry,
                  sYear,
                  sSex
    ) {
        let url = new URL('http://localhost/chartapi/ChartServer.php')
        let params = {
            sRegion: sRegion,
            sCountry: sCountry,
            sYear: sYear,
            sSex: sSex
        }
        url.search = new URLSearchParams(params).toString()
        let response = await fetch(url, {
            method: 'GET',
        });
        const data = await response.text()
        //console.log(data)
        const entries = data.split('|')
        entries.splice(entries.length-1)
        const entryName = [];
        const entryValue = [];
        entries.forEach(entry => {
            const en = entry.replaceAll("\"", "").split(',')
            entryName.push(this.getFields(en));
            entryValue.push(parseFloat(en[4]));
        })
        return { enName: entryName, enValue: entryValue };
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
}
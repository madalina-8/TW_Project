export default class ChartHandler {
    constructor(chartData) {
        this.chartData = chartData
    }

    updateType(imageFormatBox) {
        alert(imageFormatBox.value)
        switch(imageFormatBox.value) {
            case "CSV":
                misc.MIME_TYPE = "text/csv"
                break;
            case "PNG":
                misc.MIME_TYPE = "image/png"
                break;
            case "SCV":
                misc.MIME_TYPE = "image/scv"
                break;
            default:
            // code block
        }
        alert(misc.MIME_TYPE)
    }

    saveChart(chartId) {
        const canvas = document.getElementById(chartId);
        const imageURL = canvas.toDataURL(misc.MIME_TYPE);

        const dlLink = document.createElement('a');
        dlLink.download = "graph";
        dlLink.href = imageURL;
        dlLink.dataset.downloadurl = [misc.MIME_TYPE, dlLink.download, dlLink.href].join(':');

        document.body.appendChild(dlLink);
        dlLink.click();
        document.body.removeChild(dlLink);
    }

    async getData(sRegion,
                  sCountry,
                  sYear,
                  sSex
    ) {
        /*let url = new URL('http://localhost/chartapi/ChartServer.php')
        let params = {
            sRegion: sRegion,
            sCountry: sCountry,
            sYear: sYear,
            sSex: sSex
        }
        url.search = new URLSearchParams(params).toString()
        let response2 = await fetch(url, {
            method: 'GET',
        });
        console.log(response2.text().valueOf())*/
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
        return { enName: entryName, enValue: entryValue };
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
        if(array.length === 0) {
            return true
        }
        let empty = true
        array.forEach(element => {
            if(element !== "" && element !== this.chartData.defaultValue) {
                empty = false
            }
        })
        return empty;
    }

    getFields(cols) {
        let fieldsToGet = [this.chartData.columnCountry, this.chartData.columnYear, this.chartData.columnSex]
        let concatenatedValue = ""
        fieldsToGet.forEach(field => {
            concatenatedValue = concatenatedValue + cols[field] + " "
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
                this.chartData.selectedRegion = [options.valueOf().value]
                break;
            case this.chartData.columnCountry:
                this.chartData.selectedCountry = [options.valueOf().value]
                break;
            case this.chartData.columnYear:
                this.chartData.selectedYear = [options.valueOf().value]
                break;
            case this.chartData.columnSex:
                this.chartData.selectedSex = [options.valueOf().value]
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
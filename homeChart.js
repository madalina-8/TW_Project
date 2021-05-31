
/**
 * Model
 * Handles all the data
 */

class Miscellaneous {
    constructor() {
        this.MIME_TYPE = "image/png"
        this.testFileName = "text.csv"
        this.dataFileName = "data.csv"
        this.mainChartNameId = "mainChart"
    }
}

class ColorManager {
    constructor() {
        this.colors = ["#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#00FFFF", "#FF00FF"]
        // red        green      blue       yellow     cyan       magenta
        this.colorsIterator = 0

        this.borderColors = ["#00FF00", "#FF0000", "#FFFF00", "#0000FF", "#FF00FF", "#00FFFF"]
        //green       red        yellow      blue      magenta     cyan
        this.borderColorsIterator = 0
    }

    iterateColorsAndIncrement(ch) {
        let valueToReturn = ch.colorsIterator
        if(ch.colorsIterator < ch.colors.length - 1) {
            ch.colorsIterator = ch.colorsIterator + 1
        } else {
            ch.colorsIterator = 0
        }
        return valueToReturn
    }

    iterateBorderColorsAndIncrement(ch) {
        let valueToReturn = ch.borderColorsIterator
        if(ch.borderColorsIterator < ch.borderColors.length - 1) {
            ch.borderColorsIterator = ch.borderColorsIterator + 1
        } else {
            ch.borderColorsIterator = 0
        }
        return valueToReturn
    }

    getXColors(x, func, ch) {
        const colorsList = [];
        while(x > 0) {
            colorsList.push(ch.colors[func(ch)])
            x = x-1
        }
        return colorsList
    }

}

class ChartData {
    constructor() {
        // The order in the csv files is as stands:
        // Location___Country___Year___Sex___Value
        // 0          1         2      3     4
        this.selectedRegion = ["Europe"] // getCookie for list
        this.selectedCountry = ["Romania", "Bulgaria", "Germany"] // getCookie for list
        this.selectedYear = ["2016"] // getCookie for list
        this.selectedSex = ["Male"] // getCookie for list

        this.columnRegion = 0
        this.columnCountry = 1
        this.columnYear = 2
        this.columnSex = 3
        this.columnValue = 4

        this.idRegion = "region"
        this.idCountry = "country"
        this.idYear = "year"
        this.idSex = "sex"
        this.idValue = "value"
    }
}

/**
 * Controller
 * Handles all the data manipulation
 */

class ChartHandler {
    constructor() {}

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
        let response = await fetch(url, {
            method: 'GET',
        });
        console.log(response.text())*/
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
        return (sRegion.includes(cols[chartData.columnRegion]) || this.isArrayEmpty(sRegion)) &&
            (sCountry.includes(cols[chartData.columnCountry]) || this.isArrayEmpty(sCountry)) &&
            (sYear.includes(cols[chartData.columnYear]) || this.isArrayEmpty(sYear)) &&
            (sSex.includes(cols[chartData.columnSex]) || this.isArrayEmpty(sSex));
    }

    isArrayEmpty(array) {
        if(array.length === 0) {
            return true
        }
        let empty = true
        array.forEach(element => {
            if(element !== "") {
                empty = false
            }
        })
        return empty;
    }

    getFields(cols) {
        let fieldsToGet = [chartData.columnCountry, chartData.columnYear, chartData.columnSex]
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
            case chartData.columnRegion:
                console.log("data is ")
                console.log(options.valueOf().value)
                chartData.selectedRegion = options.valueOf().value
                // this.setCookie(optionsID, chartData.selectedRegion, 7)
                break;
            case chartData.columnCountry:
                chartData.selectedCountry = options.valueOf().value
                // this.setCookie(optionsID, chartData.selectedCountry, 7)
                break;
            case chartData.columnYear:
                chartData.selectedYear = options.valueOf().value
                // this.setCookie(optionsID, chartData.selectedYear, 7)
                break;
            case chartData.columnSex:
                chartData.selectedSex = options.valueOf().value
                // this.setCookie(optionsID, chartData.selectedSex, 7)
                break;
            default:
                console.log("???")
        }
    }

    setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    async getSuggestionsForColumn(fieldColumn) {
        const response = await fetch(misc.dataFileName)
        const data = await response.text()
        let fields = []
        const rows = data.split('\n').slice(1)
        rows.forEach(row =>{
            const cols = row.split(',');
            fields.push(cols[fieldColumn])
        })
        fields = this.RemoveDuplicates(fields)
        console.log(fields)
        return fields
    }

    RemoveDuplicates(arr) {
        let s = new Set(arr);
        let it = s.values();
        return Array.from(it);
    }

    filter() {
        this.updateField(chartData.columnRegion, chartData.idRegion)
        this.updateField(chartData.columnCountry, chartData.idCountry)
        this.updateField(chartData.columnYear, chartData.idYear)
        this.updateField(chartData.columnSex, chartData.idSex)
        viewHandler.refreshChart()
    }

}

/**
 * View
 * Updates the UI
 */

class ViewHandler {

    updateDataFromCookies() {
        chartData.selectedRegion = this.getValueFromCookie(chartData.idRegion)
        chartData.selectedCountry = this.getValueFromCookie(chartData.idCountry)
        chartData.selectedSex = this.getValueFromCookie(chartData.idSex)
        chartData.selectedYear = this.getValueFromCookie(chartData.idYear)
    }

    async generateChart(chartID) {
        const ctx = document.getElementById(chartID).getContext('2d');
        const data = await chartHandler.getData(
            chartData.selectedRegion,
            chartData.selectedCountry,
            chartData.selectedYear,
            chartData.selectedSex
        );
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.enName,
                datasets: [
                    { //https://jsfiddle.net/flivni/Lcnj1e5x/
                        label: 'Average obesity percentage',
                        data: data.enValue,
                        fill: false,
                        borderColor: colorManager.getXColors(data.enName.length, colorManager.iterateBorderColorsAndIncrement, colorManager),
                        backgroundColor: colorManager.getXColors(data.enName.length, colorManager.iterateColorsAndIncrement, colorManager),
                        borderWidth: 1
                    }
                ]
            },
            options: {}
        });
    }

    refreshChart() {
        if(window.myChart != null) {
            window.myChart.destroy()
        }
        this.generateChart(misc.mainChartNameId)
    }

    getCookie(name) {
        try {
            return document.cookie.split('; ')
                .find(row => row.startsWith(name + '='))
                .split('=')[1]
        } catch (error) {
            return ""
        }
    }

    getValueFromCookie(name) {
        console.log(this.getCookie(name).split("%2C"))
        return this.getCookie(name).split("%2C")
    }

    updateUIValueFromCookie(optionsID) {
        let options = document.getElementById(optionsID)
        let cookieValues = this.getValueFromCookie(optionsID)
        if(cookieValues.length !== 0) {
            options.valueOf().value = this.getValueFromCookie(optionsID)
        } else {
            options.valueOf().value = []
        }
        // console.log(options.valueOf().value)
        // does not update the UI though... ?
    }

}

/**
 * Model
 */
const chartData = new ChartData()
const colorManager = new ColorManager()
const misc = new Miscellaneous()

/**
 * Controller
 */
const chartHandler = new ChartHandler()

/**
 * View
 */

const viewHandler = new ViewHandler()
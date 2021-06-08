import ChartData from './model/ChartData.js'
import ColorManager from './model/ColorManager.js'
import Miscellaneous from './model/Miscellaneous.js'
import ChartHandler from './controller/ChartHandler.js'

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

    setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    updateSelection(choiceBoxId, selectionsChoiceBoxId) {
        let choiceBox = document.querySelector('#' + choiceBoxId)
        let selectionChoiceBox = document.querySelector('#' + selectionsChoiceBoxId)
        let newOption = new Option(choiceBox.valueOf().value, choiceBox.valueOf().value)
        selectionChoiceBox.appendChild(newOption)
    }

    removeCurrentChoice(selectionsChoiceBoxId) {
        let selectionChoiceBox = document.querySelector('#' + selectionsChoiceBoxId)
        selectionChoiceBox.children.item(selectionChoiceBox.valueOf().index).remove()
    }


}

/**
 * Model
 */
export const chartData = new ChartData()
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


export async function addOptionsForParameter(
    fieldColumn,
    choiceBoxId
) {
    const response = await fetch("data.csv")
    const data = await response.text()
    let fields = []
    const rows = data.split('\n').slice(1)
    rows.forEach(row =>{
        const cols = row.split(',');
        fields.push(cols[fieldColumn])
    })
    fields = chartHandler.RemoveDuplicates(fields)
    let choiceBox = document.querySelector('#' + choiceBoxId)
    let newOption = new Option(chartData.defaultValue.valueOf(), chartData.defaultValue)
    choiceBox.appendChild(newOption)
    fields.forEach(field => {
        let newOption = new Option(field, field)
        choiceBox.appendChild(newOption)
    })
    let value = getCookie(choiceBoxId)
    if (value === undefined) {
        value = chartData.defaultValue
    }
    choiceBox.value = value
    chartHandler.updateField(fieldColumn, choiceBoxId)
}
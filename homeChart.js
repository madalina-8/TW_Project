import ChartData from './model/ChartData.js'
import ColorManager from './model/ColorManager.js'
import Miscellaneous from './model/Miscellaneous.js'
import ChartHandler from './controller/ChartHandler.js'
import ViewHandler from './view/ViewHandler.js';

/**
 * Model
 */
export const chartData = new ChartData()
export const colorManager = new ColorManager()
export const misc = new Miscellaneous()

/**
 * Controller
 */
export const chartHandler = new ChartHandler(chartData)

/**
 * View
 */

export const viewHandler = new ViewHandler(chartData, chartHandler, colorManager, misc)


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
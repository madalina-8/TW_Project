import ChartData from '../model/ChartData.js'
import ColorManager from '../model/ColorManager.js'
import Miscellaneous from '../model/Miscellaneous.js'
import ChartHandler from '../controller/ChartHandler.js'
import ViewHandler from '../view/ViewHandler.js';

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

export const viewHandler = new ViewHandler(
    chartData,
    chartHandler,
    colorManager,
    misc
)
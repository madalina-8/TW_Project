export default class ViewHandler {

    constructor(chartData, chartHandler, colorManager, misc) {
        this.chartData = chartData
        this.chartHandler = chartHandler
        this.colorManager = colorManager
        this.misc = misc
    }

    async generateChart(
        chartID,
        selectedRegions,
        selectedCountries,
        selectedYears,
        selectedSexes
    ) {
        const ctx = document.getElementById(chartID).getContext('2d');
        const data = await this.chartHandler.getData(
            selectedRegions,
            selectedCountries,
            selectedYears,
            selectedSexes
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
                        borderColor: this.colorManager.getXColors(data.enName.length, this.colorManager.iterateBorderColorsAndIncrement, this.colorManager),
                        backgroundColor: this.colorManager.getXColors(data.enName.length, this.colorManager.iterateColorsAndIncrement, this.colorManager),
                        borderWidth: 1
                    }
                ]
            },
            options: {}
        });
    }

    async addOptionsForParameter(
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
        fields = this.chartHandler.RemoveDuplicates(fields)
        let choiceBox = document.querySelector('#' + choiceBoxId)
        let newOption = new Option(this.chartData.defaultValue.valueOf(), this.chartData.defaultValue)
        choiceBox.appendChild(newOption)
        fields.forEach(field => {
            let newOption = new Option(field, field)
            choiceBox.appendChild(newOption)
        })
    }
}
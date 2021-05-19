var MIME_TYPE = "image/png";

function updateType(imageFormatBox) {
    alert(imageFormatBox.value)
    switch(imageFormatBox.value) {
        case "CSV":
            MIME_TYPE = "text/csv"
            break;
        case "PNG":
            MIME_TYPE = "image/png"
            break;
        case "SCV":
            MIME_TYPE = "image/scv"
            break;
        default:
        // code block
    }
    alert(MIME_TYPE)
}

function saveChart() {
    const canvas = document.getElementById("mainChart");
    const MIME_TYPE = "image/png";
    const imageURL = canvas.toDataURL(MIME_TYPE);

    const dlLink = document.createElement('a');
    dlLink.download = "testFileName";
    dlLink.href = imageURL;
    dlLink.dataset.downloadurl = [MIME_TYPE, dlLink.download, dlLink.href].join(':');

    document.body.appendChild(dlLink);
    dlLink.click();
    document.body.removeChild(dlLink);
}

async function generateChart(chartID) {
    const ctx = document.getElementById(chartID).getContext('2d');
    const data = await getData(
        defaultValue,
        selectedRegion,
        selectedCountry,
        selectedYear,
        selectedSex
    );
    window.myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.enName,
        datasets: [
          {
            label: 'Average obesity percentage in ' + selectedYear + " for males",
            data: data.enValue,
            fill: false,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderWidth: 1
          }
        ]
      },
      options: {}
    });
}
const testFileName = "text.csv"
const dataFileName = "data.csv"
let mainChartNameId = "mainChart"

let defaultValue = "-" //default value in the UI
let selectedRegion = defaultValue
let selectedCountry = defaultValue
let selectedYear = defaultValue
let selectedSex = defaultValue

let columnRegion = 0
let columnCountry = 1
let columnYear = 2
let columnSex = 3
let columnValue = 4

// The order in the csv files is as stands:
    // Location___Country___Year___Sex___Value
    // 0          1         2      3     4

async function getData(dValue,
                       sRegion,
                       sCountry,
                       sYear,
                       sSex
) {
    const response = await fetch(dataFileName);
    const data = await response.text();
    const entryName = [];
    const entryValue = [];
    const rows = data.split('\n').slice(1);
    rows.forEach(row => {
        const cols = row.split(',');
        if(isSelectableData(cols, dValue, sRegion, sCountry, sYear, sSex)) {
            entryName.push(getFields(cols));
            entryValue.push(parseFloat(cols[4]));
        }
    });
    return { enName: entryName, enValue: entryValue };
}

function isSelectableData(cols,
                          dValue,
                          sRegion,
                          sCountry,
                          sYear,
                          sSex
) {
    return (sRegion === dValue || sRegion === cols[0]) &&
        (sCountry === dValue || sCountry === cols[1]) &&
        (sYear === dValue || sYear === cols[2]) &&
        (sSex === dValue || sSex === cols[3]);
}

function getFields(cols) {
    let fieldsToGet = [columnCountry, columnYear, columnSex]
    let concatenatedValue = ""
    fieldsToGet.forEach(field => {
        concatenatedValue = concatenatedValue + cols[field] + " "
    })
    return concatenatedValue
}

function updateField(
    fieldColumn,
    choiceBoxId
) {
    let choiceBox = document.querySelector('#' + choiceBoxId)
    switch(fieldColumn) {
        case columnRegion:
            selectedRegion = choiceBox.valueOf().value
            break;
        case columnCountry:
            selectedCountry = choiceBox.valueOf().value
            break;
        case columnYear:
            selectedYear = choiceBox.valueOf().value
            break;
        case columnSex:
            selectedSex = choiceBox.valueOf().value
            break;
        default:
            console.log("???")
    }
    refreshUI()
}

function refreshUI() {
    console.log("Updating UI")
    if(window.myChart != null) {
        window.myChart.destroy()
    }
    generateChart(mainChartNameId)
}

async function addOptionsForParameter(
    fieldColumn,
    choiceBoxId
) {
    const response = await fetch(dataFileName)
    const data = await response.text()
    let fields = []
    const rows = data.split('\n').slice(1)
    rows.forEach(row =>{
        const cols = row.split(',');
        fields.push(cols[fieldColumn])
    })
    fields = RemoveDuplicates(fields)
    let choiceBox = document.querySelector('#' + choiceBoxId)
    let newOption = new Option("-", defaultValue)
    choiceBox.appendChild(newOption)
    fields.forEach(field => {
        let newOption = new Option(field, field)
        choiceBox.appendChild(newOption)
    })
}

function RemoveDuplicates(arr) {
    let s = new Set(arr);
    let it = s.values();
    return Array.from(it);
}
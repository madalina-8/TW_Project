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

let myChart

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
    const data = await getData();
    window.myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.enName,
        datasets: [
          {
            label: 'Average obesity percentage in ' + selectedYear,
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

let defaultValue = "-"
let selectedLocation = ""
let selectedCountry = "Afghanistan" //default value in the UI
let selectedYear = "2016" //default value in the UI
let selectedSex = "Male" //default value in the UI
let mainChartNameId = "mainChart"

async function getData() {
    const response = await fetch(dataFileName);
    const data = await response.text();
    const entryName = [];
    const entryValue = [];
    const rows = data.split('\n').slice(1);
    rows.forEach(row => {
        const cols = row.split(',');
        if(isSelectableData(cols)) {
            entryName.push(getFields(cols));
            entryValue.push(parseFloat(cols[4]));
        }
    });
    return { enName: entryName, enValue: entryValue };
}

// The order in the csv files is as stands:
    // Location___Country___Year___Sex___Value
    // 0          1         2      3     4
function isSelectableData(cols) {
    return (selectedLocation === "" || selectedLocation === cols[0]) &&
        (selectedCountry === "" || selectedCountry === cols[1]) &&
        (selectedYear === "" || selectedYear === cols[2]) &&
        (selectedSex === "" || selectedSex === cols[3]);
}

function getFields(cols) {
    return cols[1] + " " + cols[2] + " " + cols[3]
}

function addYearOptions() {
    let yearChoiceBox = document.querySelector('#year')
    for (let i = 2016; i >= 1975; i--) {
        let newOption = new Option(i, i)
        yearChoiceBox.appendChild(newOption)
    }
}

function updateYear() {
    let yearChoiceBox = document.querySelector('#year')
    selectedYear = yearChoiceBox.valueOf().value
    refreshUI()
}

function updateSex() {
    let sexChoiceBox = document.querySelector('#sex')
    selectedSex = sexChoiceBox.valueOf().value
    refreshUI()
}

function updateCountry() {
    let countryChoiceBox = document.querySelector('#country')
    selectedCountry = countryChoiceBox.valueOf().value
    refreshUI()
}

function refreshUI() {
    console.log("Updating UI")
    if(window.myChart != null) {
        window.myChart.destroy()
    }
    generateChart(mainChartNameId)
}

async function addCountryOptions() {
    let countryChoiceBox = document.querySelector('#country')

    const response = await fetch(dataFileName);
    const data = await response.text();
    let countries = []
    const rows = data.split('\n').slice(1)
    rows.forEach(row =>{
        const cols = row.split(',');
        countries.push(cols[1])
    });
    countries = RemoveDuplicates(countries)
    countries.forEach(country => {
        let newOption = new Option(country, country)
        countryChoiceBox.appendChild(newOption)
    });
}

function RemoveDuplicates(arr) {
    let s = new Set(arr);
    let it = s.values();
    return Array.from(it);
}
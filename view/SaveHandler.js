let MIME_TYPE = "image/png"

function updateType(imageFormatBox) {
    switch(imageFormatBox.value) {
        case "CSV":
            MIME_TYPE = "text/csv"
            break;
        case "PNG":
            MIME_TYPE = "image/png"
            break;
        case "SVG":
            MIME_TYPE = "image/svg+xml"
            break;
        default:
        // code block
    }
}

function saveChart(chartId) {
    let encodedUri
    let termination = ""
    const dlLink = document.createElement('a');
    if(MIME_TYPE === "text/csv") {
        let csvContent = "data:text/csv;charset=utf-8,";
        for(let i = 0; i < window.myChart.data.labels.length; i++) {
            csvContent = csvContent + window.myChart.data.labels[i] + "," + window.myChart.data.datasets[0].data[i] + '\n'
        }
        encodedUri = encodeURI(csvContent);
        termination = ".csv"
    } else {
        const canvas = document.getElementById(chartId);
        encodedUri = canvas.toDataURL(MIME_TYPE);
        dlLink.dataset.downloadurl = [MIME_TYPE, dlLink.download, dlLink.href].join(':');
    }
    dlLink.download = "data" + termination;
    dlLink.href = encodedUri;
    document.body.appendChild(dlLink);
    dlLink.click();
    document.body.removeChild(dlLink);
}
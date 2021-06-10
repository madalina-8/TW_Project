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
    const canvas = document.getElementById(chartId);
    console.log(MIME_TYPE)
    //const imageURL = canvas.toDataURL(MIME_TYPE);
    const imageURL = 'data:' + MIME_TYPE + "," + encodeURIComponent(canvas.outerHTML);
    console.log(imageURL)

    const dlLink = document.createElement('a');
    dlLink.download = "graph";
    dlLink.href = imageURL;
    dlLink.dataset.downloadurl = [MIME_TYPE, dlLink.download, dlLink.href].join(':');

    document.body.appendChild(dlLink);
    dlLink.click();
    document.body.removeChild(dlLink);

    window.myChart.exports
}
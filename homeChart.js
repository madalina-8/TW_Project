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

function generateChart(chartID) { //This will also take data as arguments
    let mainChart = document.getElementById(chartID).getContext('2d');
    let myChart = new Chart(mainChart, {
        exportFileName: "obesityChart",
        exportEnabled: true,
        animationEnabled: true,
        type: 'bar',
        data: {
            labels: ['Romania', 'USA', 'Germany'],
            datasets: [{
                label: 'Obesity rate',
                data: [
                    22.5,
                    42.4,
                    22.3
                ],
                backgroundColor: [
                    '#F05D5E',
                    '#24262b',
                    '#E1E1E1'
                ],
            }]
        },
        options: {},
    })
}

function saveChart() {
    var canvas = document.getElementById("mainChart");
    var MIME_TYPE = "image/png";
    var imageURL = canvas.toDataURL(MIME_TYPE);

    var dlLink = document.createElement('a');
    dlLink.download = "fileName";
    dlLink.href = imageURL;
    dlLink.dataset.downloadurl = [MIME_TYPE, dlLink.download, dlLink.href].join(':');

    document.body.appendChild(dlLink);
    dlLink.click();
    document.body.removeChild(dlLink);
}
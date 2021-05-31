async function getData(sRegion,
                  sCountry,
                  sYear,
                  sSex
    ) {
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

function isSelectableData(cols,
                     sRegion,
                     sCountry,
                     sYear,
                     sSex
    ) {
        return (sRegion.includes(cols[chartData.columnRegion]) || sRegion.length === 0) &&
            (sCountry.includes(cols[chartData.columnCountry]) || sCountry.length === 0) &&
            (sYear.includes(cols[chartData.columnYear]) || sYear.length === 0) &&
            (sSex.includes(cols[chartData.columnSex]) || sSex.length === 0);
}

function getFields(cols) {
        let fieldsToGet = [chartData.columnCountry, chartData.columnYear, chartData.columnSex]
        let concatenatedValue = ""
        fieldsToGet.forEach(field => {
            concatenatedValue = concatenatedValue + cols[field] + " "
        })
        return concatenatedValue
}
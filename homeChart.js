    let mainChart = document.getElementById("mainChart").getContext('2d');

    new Chart(mainChart, {
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

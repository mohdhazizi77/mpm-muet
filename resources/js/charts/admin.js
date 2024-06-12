$(document).ready(function() {

    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                    else return newValue;;
                } else {
                    var val = value.split(',');
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        }
    }

    // double line chart
    var linechartDatalabelColors = getChartColorsArray("line_chart_muet_mod");
    if (linechartDatalabelColors) {
        var options = {
            chart: {
                height: 380,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            colors: linechartDatalabelColors,
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: [3, 3],
                curve: 'straight'
            },
            series: [{
                    name: "MUET -  2024",
                    data: [26, 24, 32, 36, 33, 31, 33, 28, 30, 27, 29, 34]

                },
                {
                    name: "MOD - 2024",
                    data: [14, 11, 16, 12, 17, 13, 12, 15, 14, 10, 13, 18]

                }
            ],
            title: {
                text: 'Collection from Jan to Dec',
                align: 'left',
                style: {
                    fontWeight: 500,
                },
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.2
                },
                borderColor: '#f1f1f1'
            },
            markers: {
                style: 'inverted',
                size: 6
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                title: {
                    text: 'Month'
                }
            },
            yaxis: {
                title: {
                    text: 'Temperature'
                },
                min: 5,
                max: 40
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        toolbar: {
                            show: false
                        }
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#line_chart_muet_mod"),
            options
        );
        chart.render();
    }

    //pie chart MUET 60:20
    var chartPieBasicColors = getChartColorsArray("piechart_muet");
    if(chartPieBasicColors){
        var options = {
            series: [44, 55, ],
            chart: {
                height: 300,
                type: 'pie',
            },
            labels: ['RM 60', 'RM20'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false,
                }
            },
            colors: chartPieBasicColors
        };

        var chart = new ApexCharts(document.querySelector("#piechart_muet"), options);
        chart.render();
    }

    //pie chart MOD 60:20
    var chartPieBasicColors = getChartColorsArray("piechart_mod");
    if(chartPieBasicColors){
        var options = {
            series: [43, 22],
            chart: {
                height: 300,
                type: 'pie',
            },
            labels: ['RM 60', 'RM 20',],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false,
                }
            },
            colors: chartPieBasicColors
        };

        var chart = new ApexCharts(document.querySelector("#piechart_mod"), options);
        chart.render();
    }
});

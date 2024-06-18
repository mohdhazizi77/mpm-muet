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
        $.ajax({
            url: './admin/dashboard-line-chart', // Adjust the URL to match your route
            method: 'GET',
            success: function(response) {
                var muetData = response.muet;
                var modData = response.mod;

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
                            name: "MUET - " + new Date().getFullYear(),
                            data: muetData
                        },
                        {
                            name: "MOD - " + new Date().getFullYear(),
                            data: modData
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
                            text: 'Count'
                        },
                        min: 0,
                        max: Math.max(Math.max(...muetData), Math.max(...modData)) + 5 // Adjust max y-axis value
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
                };

                var chart = new ApexCharts(
                    document.querySelector("#line_chart_muet_mod"),
                    options
                );
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    //pie chart MUET 60:20
    var chartPieBasicColors = getChartColorsArray("piechart_muet");
    if(chartPieBasicColors){
        $.ajax({
            url: './admin/dashboard-muet-pie-chart',
            method: 'GET',
            success: function(response) {
                var data = response;

                var chartData = data.map(function(item) {
                    return {
                        x: item.label,
                        y: item.value
                    };
                });

                var options = {
                    series: chartData.map(function(item) {
                        return item.y;
                    }),
                    chart: {
                        height: 300,
                        type: 'pie',
                    },
                    labels: chartData.map(function(item) {
                        return item.x;
                    }),
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

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    //pie chart MOD 60:20
    var chartPieBasicColors = getChartColorsArray("piechart_mod");
    if(chartPieBasicColors){
        $.ajax({
            url: './admin/dashboard-mod-pie-chart',
            method: 'GET',
            success: function(response) {
                var data = response;

                var chartData = data.map(function(item) {
                    return {
                        x: item.label,
                        y: item.value
                    };
                });

                var options = {
                    series: chartData.map(function(item) {
                        return item.y;
                    }),
                    chart: {
                        height: 300,
                        type: 'pie',
                    },
                    labels: chartData.map(function(item) {
                        return item.x;
                    }),
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

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    
});



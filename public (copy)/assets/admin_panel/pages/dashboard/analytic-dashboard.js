'use strict';

$(document).ready(function() {

    widgetChart();

    function widgetChart() {

        var chart = AmCharts.makeChart("visitor-list-graph", {
            "type": "serial",
            // "hideCredits": true,
            "theme": "light",
            "dataDateFormat": "YYYY-MM-DD",
            "precision": 2,
            "valueAxes": [{
                "id": "v1",
                "title": "Visitors",
                "position": "left",
                "autoGridCount": false,
                "labelFunction": function(value) {
                    return "$" + Math.round(value) + "M";
                }
            }, {
                "id": "v2",
                "title": "New Visitors",
                "gridAlpha": 0,
                "position": "right",
                "autoGridCount": false
            }],
            "graphs": [{
                "id": "g3",
                "valueAxis": "v1",
                "lineColor": '#a8d1ff',
                "fillColors": '#a8d1ff',
                "fillAlphas": 1,
                "type": "column",
                "title": "old Visitor",
                "valueField": "sales2",
                "clustered": false,
                "columnWidth": 0.5,
                "legendValueText": "$[[value]]M",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                "id": "g4",
                "valueAxis": "v1",
                "lineColor": "#4099ff",
                "fillColors": "#4099ff",
                "fillAlphas": 1,
                "type": "column",
                "title": "New visitor",
                "valueField": "sales1",
                "clustered": false,
                "columnWidth": 0.3,
                "legendValueText": "$[[value]]M",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                "id": "g1",
                "valueAxis": "v2",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 50,
                "lineThickness": 2,
                "lineColor": "#2ed8b6",
                "type": "smoothedLine",
                "title": "Last Month Visitor",
                "useLineColorForBulletBorder": true,
                "valueField": "market1",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g2",
                "valueAxis": "v2",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 50,
                "lineThickness": 2,
                "lineColor": "#FF5370",
                // "type": "smoothedLine",
                "dashLength": 5,
                "title": "Average Visitor",
                "useLineColorForBulletBorder": true,
                "valueField": "market2",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }],
            "chartCursor": {
                "pan": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "cursorAlpha": 0,
                "valueLineAlpha": 0.2
            },
            "categoryField": "date",
            "categoryAxis": {
                "parseDates": true,
                "dashLength": 1,
                "minorGridEnabled": true
            },
            "legend": {
                "useGraphSettings": true,
                "position": "top"
            },
            "balloon": {
                "borderThickness": 1,
                "cornerRadius": 5,
                "shadowAlpha": 0
            },
            "dataProvider": [{
                "date": "2013-01-16",
                "market1": 71,
                "market2": 75,
                "sales1": 5,
                "sales2": 8
            }, {
                "date": "2013-01-17",
                "market1": 74,
                "market2": 78,
                "sales1": 4,
                "sales2": 6
            }, {
                "date": "2013-01-18",
                "market1": 78,
                "market2": 88,
                "sales1": 5,
                "sales2": 2
            }, {
                "date": "2013-01-19",
                "market1": 85,
                "market2": 89,
                "sales1": 8,
                "sales2": 9
            }, {
                "date": "2013-01-20",
                "market1": 82,
                "market2": 89,
                "sales1": 9,
                "sales2": 6
            }, {
                "date": "2013-01-21",
                "market1": 83,
                "market2": 85,
                "sales1": 3,
                "sales2": 5
            }, {
                "date": "2013-01-22",
                "market1": 88,
                "market2": 92,
                "sales1": 5,
                "sales2": 7
            }, {
                "date": "2013-01-23",
                "market1": 85,
                "market2": 90,
                "sales1": 7,
                "sales2": 6
            }, {
                "date": "2013-01-24",
                "market1": 85,
                "market2": 91,
                "sales1": 9,
                "sales2": 5
            }, {
                "date": "2013-01-25",
                "market1": 80,
                "market2": 84,
                "sales1": 5,
                "sales2": 8
            }, {
                "date": "2013-01-26",
                "market1": 87,
                "market2": 92,
                "sales1": 4,
                "sales2": 8
            }, {
                "date": "2013-01-27",
                "market1": 84,
                "market2": 87,
                "sales1": 3,
                "sales2": 4
            }, {
                "date": "2013-01-28",
                "market1": 83,
                "market2": 88,
                "sales1": 5,
                "sales2": 7
            }, {
                "date": "2013-01-29",
                "market1": 84,
                "market2": 87,
                "sales1": 5,
                "sales2": 8
            }, {
                "date": "2013-01-30",
                "market1": 81,
                "market2": 85,
                "sales1": 4,
                "sales2": 7
            }]
        });

        $("span.pie_1").peity("pie", {
            fill: ["#D9D9D9", "#4099ff"]
        });
        $("span.pie_2").peity("pie", {
            fill: ["#D9D9D9", "#FFB64D"]
        });
        $("span.pie_3").peity("pie", {
            fill: ["#D9D9D9", "#FF5370"]
        });
        $("span.pie_4").peity("pie", {
            fill: ["#D9D9D9", "#2ed8b6"]
        });
        $("span.pie_5").peity("pie", {
            fill: ["#D9D9D9", "#00bcd4"]
        });
        $("span.pie_6").peity("pie", {
            fill: ["#D9D9D9", "#FE8A7D"]
        });
        // chart js function start
        function amuntjs(a, b, f) {
            if (f == null) {
                f = "rgba(0,0,0,0)";
            }
            return {
                labels: ["1", "2", "3", "4", "5"],
                datasets: [{
                    label: "",
                    borderColor: a,
                    borderWidth: 2,
                    hitRadius: 30,
                    pointHoverRadius: 4,
                    pointBorderWidth: 50,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                    pointHoverBackgroundColor: a,
                    pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.1).rgbString(),
                    fill: true,
                    backgroundColor: f,
                    data: b,
                }]
            };
        }
        function buildchartoption() {
            return {
                title: {
                    display: !1
                },
                tooltips: {
                    enabled: true,
                    intersect: !1,
                    mode: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: !1,
                    labels: {
                        usePointStyle: !1
                    }
                },
                responsive: !0,
                maintainAspectRatio: !0,
                hover: {
                    mode: "index"
                },
                scales: {
                    xAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Month"
                        }
                    }],
                    yAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Value"
                        },
                        ticks: {
                            beginAtZero: !0
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            };
        }
        // chart js function end

        // amunt card start
        var ctx = document.getElementById('amunt-card1').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: amuntjs('#fff', [40, 30, 45, 30, 35], '#fff'),
            options: buildchartoption(),
        });
        var ctx = document.getElementById('amunt-card2').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: amuntjs('#fff', [30, 35, 40, 30, 45], '#fff'),
            options: buildchartoption(),
        });
        var ctx = document.getElementById('amunt-card3').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: amuntjs('#fff', [45, 30, 40, 30, 35], '#fff'),
            options: buildchartoption(),
        });
        var ctx = document.getElementById('amunt-card4').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: amuntjs('#fff', [45, 30, 35, 40, 30], '#fff'),
            options: buildchartoption(),
        });
        // amunt card start

        var ctx = document.getElementById('power-card-chart1').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: gurubuildchartjs('#4099ff', [10, 25, 35, 20, 10, 20, 15, 45, 15, 10]),
            options: gurubuildchartoption(),
        });
        var ctx = document.getElementById('power-card-chart2').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: gurubuildchartjs('#FFB64D', [45, 25, 35, 20, 45, 20, 40, 10, 30, 45]),
            options: gurubuildchartoption(),
        });
        var ctx = document.getElementById('power-card-chart3').getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: gurubuildchartjs('#2ed8b6', [5, 35, 45, 20, 10, 30, 15, 45, 15, 10]),
            options: gurubuildchartoption(),
        });
        function gurubuildchartjs(a, b, f) {
            if (f == null) {
                f = "rgba(0,0,0,0)";
            }
            return {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "",
                    borderColor: a,
                    borderWidth: 2,
                    hitRadius: 30,
                    pointHoverRadius: 4,
                    pointBorderWidth: 50,
                    pointHoverBorderWidth: 12,
                    pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                    pointHoverBackgroundColor: a,
                    pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.1).rgbString(),
                    fill: true,
                    backgroundColor: f,
                    data: b,
                }]
            };
        }
        function gurubuildchartoption() {
            return {
                title: {
                    display: !1
                },
                tooltips: {
                    enabled: true,
                    intersect: !1,
                    mode: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: !1,
                    labels: {
                        usePointStyle: !1
                    }
                },
                responsive: !0,
                maintainAspectRatio: !0,
                hover: {
                    mode: "index"
                },
                scales: {
                    xAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Month"
                        }
                    }],
                    yAxes: [{
                        display: !1,
                        gridLines: !1,
                        scaleLabel: {
                            display: !0,
                            labelString: "Value"
                        },
                        ticks: {
                            beginAtZero: !0
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 5,
                        bottom: 0
                    }
                }
            };
        }
    }
});

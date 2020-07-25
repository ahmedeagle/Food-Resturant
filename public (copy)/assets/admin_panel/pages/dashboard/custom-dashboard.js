'use strict';
$(document).ready(function() {

    // chart js function start
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

    var chart = AmCharts.makeChart( "Statistics-chart", {

            "type": "serial",
            "theme": "light",
            // "hideCredits": true,
            "dataDateFormat": "YYYY-MM-DD",
            "precision": 2,
            "valueAxes": [{
                "id": "v1",
                "title": "Sales",
                "position": "left",
                "autoGridCount": false,
                "labelFunction": function(value) {
                    return "$" + Math.round(value) + "M";
                }
            }, {
                "id": "v2",
                "gridAlpha": 0.1,
                "autoGridCount": false
            }],
            "graphs": [{
                "id": "g1",
                "valueAxis": "v2",
                "lineThickness": 0,
                "fillAlphas": 0.2,
                "lineColor": "#4099ff",
                "type": "line",
                "title": "Laptop",
                "useLineColorForBulletBorder": true,
                "valueField": "market1",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g2",
                "valueAxis": "v2",
                "fillAlphas": 0.6,
                "lineThickness": 0,
                "lineColor": "#4099ff",
                "type": "line",
                "title": "TV",
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
                "gridAlpha" : 0,
                "minorGridEnabled": true
            },
            "legend": {
                "position":"top",
            },
            "balloon": {
                "borderThickness": 1,
                "shadowAlpha": 0
            },
            "export": {
                "enabled": true
            },
            "dataProvider": [{
                "date": "2013-01-01",
                "market1": 0,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-02-01",
                "market1": 130,
                "market2": 110,
                "sales1": 0
            }, {
                "date": "2013-03-01",
                "market1": 80,
                "market2": 60,
                "sales1": 0
            }, {
                "date": "2013-04-01",
                "market1": 70,
                "market2": 200,
                "sales1": 0
            }, {
                "date": "2013-05-01",
                "market1": 180,
                "market2": 150,
                "sales1": 0
            }, {
                "date": "2013-06-01",
                "market1": 105,
                "market2": 90,
                "sales1": 0
            }, {
                "date": "2013-07-01",
                "market1": 250,
                "market2": 150,
                "sales1": 0
            }]
        });

    // feedback chart start
    var ctx = document.getElementById("feedback-chart").getContext("2d");
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    83, 17,
                ],
                backgroundColor: [
                    "#4099ff",
                    "#81c1fd"
                ],
                label: 'Dataset 1',
                borderWidth: 0
            }],
            labels: [
                "Positive",
                "Negative"
            ]
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: false,
                text: 'Chart.js Doughnut Chart'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };
    window.myDoughnut = new Chart(ctx, config);
    // feedback chart end

    // seo card start
    function seojs(a, b, f) {
        if (f == null) {
            f = "rgba(0,0,0,0)";
        }
        return {
            labels: ["1", "2", "3", "4", "5", "6", "7"],
            datasets: [{
                label: "",
                borderColor: a,
                borderWidth: 2,
                hitRadius: 0,
                pointHoverRadius: 0,
                pointRadius: 3,
                pointBorderWidth: 2,
                pointHoverBorderWidth: 12,
                pointBackgroundColor: Chart.helpers.color("#fff").alpha(1).rgbString(),
                pointBorderColor: Chart.helpers.color(a).alpha(1).rgbString(),
                pointHoverBackgroundColor: a,
                pointHoverBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                fill: true,
                backgroundColor: f,
                data: b,
            }]
        };
    }
    var ctx = document.getElementById('seo-card1').getContext("2d");
    var gradientFill = ctx.createLinearGradient(300, 0, 0, 300);
    gradientFill.addColorStop(0, "#b9fdef");
    gradientFill.addColorStop(1, "#2ed8b6");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: seojs('#2ed8b6', [100, 80, 100, 150, 190, 200, 160], gradientFill),
        options: buildchartoption(),
    });
    var gradientFill = ctx.createLinearGradient(300, 0, 0, 300);
    gradientFill.addColorStop(0, "#b5d8ff");
    gradientFill.addColorStop(1, "#4099ff");
    var ctx = document.getElementById('seo-card2').getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: seojs('#4099ff', [100, 80, 100, 150, 190, 200, 160], gradientFill),
        options: buildchartoption(),
    });
    // seo cardunction end

});

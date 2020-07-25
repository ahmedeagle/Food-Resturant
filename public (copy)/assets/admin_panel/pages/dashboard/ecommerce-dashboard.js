'use strict';
$(document).ready(function() {


    $(document).ready(function() {
        areaChart();
    });
    /*Area chart*/
    function areaChart() {
        var chart = AmCharts.makeChart("analythics-graph", {
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
                "fillAlphas": 0.9,
                "lineColor": "#4099ff ",
                "type": "smoothedLine",
                "title": "Laptop",
                "useLineColorForBulletBorder": true,
                "valueField": "market1",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g2",
                "valueAxis": "v2",
                "fillAlphas": 0.9,
                "bulletColor": "#FF5370 ",
                "lineThickness": 0,
                "lineColor": "#FF5370 ",
                "type": "smoothedLine",
                "title": "TV",
                "useLineColorForBulletBorder": true,
                "valueField": "market2",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g3",
                "valueAxis": "v2",
                "fillAlphas": 0.9,
                "bulletColor": "#2ed8b6",
                "lineThickness": 0,
                "lineColor": "#2ed8b6",
                "type": "smoothedLine",
                "title": "Mobile",
                "useLineColorForBulletBorder": true,
                "valueField": "sales1",
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
                "market1": 0,
                "market2": 0,
                "sales1": 40
            }, {
                "date": "2013-03-01",
                "market1": 0,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-04-01",
                "market1": 30,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-05-01",
                "market1": 0,
                "market2": 20,
                "sales1": 0
            }, {
                "date": "2013-06-01",
                "market1": 25,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-07-01",
                "market1": 0,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-08-01",
                "market1": 0,
                "market2": 0,
                "sales1": 30
            }, {
                "date": "2013-09-01",
                "market1": 0,
                "market2": 0,
                "sales1": 0
            }, {
                "date": "2013-10-01",
                "market1": 0,
                "market2": 50,
                "sales1": 0
            }, {
                "date": "2013-11-01",
                "market1": 0,
                "market2": 0,
                "sales1": 65
            }, {
                "date": "2013-12-01",
                "market1": 0,
                "market2": 0,
                "sales1": 0
            }]
        });


        // unique visitor start
        var map = AmCharts.makeChart("unique-visitor-chart", {
            "type": "map",
            "theme": "light",
            // "hideCredits": true,
            "dragMap": false,
            "projection": "eckert3",

            "areasSettings": {
                "autoZoom": false,
                "rollOverOutlineColor": "#fff",
                "selectedColor": "#fff",
                "outlineAlpha": 1,
                "outlineColor": "transparent",
                "outlineThickness": 1,
                "color": "#000000"
            },
            "dataProvider": {
                "map": "continentsLow",
                "areas": [{
                    "id": "africa",
                    "title": "Africa",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4
                    }
                }, {
                    "id": "asia",
                    "title": "Asia",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4
                    }
                }, {
                    "id": "australia",
                    "title": "Australia",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4,
                    }
                }, {
                    "id": "europe",
                    "title": "Europe",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4
                    }
                }, {
                    "id": "north_america",
                    "title": "North America",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4
                    }
                }, {
                    "id": "south_america",
                    "title": "South America",
                    "pattern": {
                        "url": "../../../images/widget/map-bg.png",
                        "width": 4,
                        "height": 4
                    }
                }]
            },
            "zoomControl": {
                "panControlEnabled": false,
                "zoomControlEnabled": false,
                "homeButtonEnabled": false
            },
        });
        // unique visitor end

    }
});

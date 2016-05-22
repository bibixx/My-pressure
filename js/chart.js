$(function () {
  var highchartsOptions = Highcharts.setOptions({
    lang: {
      months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
      weekdays: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
      shortMonths: ['sty', 'lut', 'mar', 'kwi', 'maj', 'cze', 'lip', 'sie', 'wrz', 'paź', 'lis', 'gru'],
      contextButtonTitle: "Chart context menu",
      decimalPoint: ",",
      downloadPNG: "Pobierz w PNG",
      downloadJPEG: "Pobierz w JPEG",
      downloadPDF: "Pobierz w PDF",
      downloadSVG: "Pobierz w SVG",
      loading: 'Ładowanie...',
      noData: "Brak danych do wyświetlenia",
      printChart: "Wydrukuj wykres",
      thousandsSep: " "
    }
  });

  var buttons = {
    buttons: {
      contextButton: {
        'stroke-width': 2,
        symbolStroke: "#666",
        symbolStrokeWidth: 1,
        y: 0,
        // width: 44,
        // height: 24,
        // symbolSize: 15,
        // symbolX: 22,
        // symbolY: 12,
        theme: {
          'stroke-width': 1,
          stroke: '#ddd',
          fill: '#fff',
          r: 4,
          states: {
            hover: {
              fill: '#ddd',
              stroke: '#ddd',
            },
            select: {
              fill: '#ddd',
              stroke: '#ddd',
            }
          }
        }
      }
    }
  }

  $('#container').highcharts({
    chart: {
      type: 'spline'
    },
    title: {
      text: 'Wartości mierzonego ciśnienia krwi',
      widthAdjust: -60
    },
    credits: {
      enabled: false
    },
    xAxis: {
      type: 'datetime',
      dateTimeLabelFormats: {
        month: '%e. %b',
        year: '%b'
      },
      title: {
        text: 'Data'
      }
    },
    yAxis: {
      title: {
        text: 'Wartość ciśnienia (mmHg)'
      },
      gridLineColor: '#ccc',
      gridLineWidth: 1,
      alternateGridColor: null,
      plotBands: [{
          from: 122,
          to: 147,
          color: "rgba(255, 0, 0, 0.1)",
          label: {
              style: {
                  color: '#606060'
              }
          }
      }, {
          from: 70,
          to: 97,
          color: "rgba(0, 120, 255, 0.1)",
          label: {
              style: {
                  color: '#606060'
              }
          }
      }]
    },
    tooltip: {
        valueSuffix: ' mmHg'
    },
    exporting: buttons,
    plotOptions: {
      spline: {
        lineWidth: 4,
        states: {
            hover: {
                lineWidth: 5
            }
        },
        tooltip: {
        	dateTimeLabelFormats: {
          	millisecond:"%A, %e %b, %H:%M:%S.%L",
            second:"%A, %e %b, %H:%M:%S",
            minute:"%A, %e %b, %H:%M",
            hour:"%A, %e %b, %H:%M",
            day:"%A, %e %b, %Y",
            week:"Week from %A, %e %b, %Y",
            month:"%B %Y",
            year:"%Y"
          }
        }
      }
    },
    series: [{
        name: 'SYS',
        color: "rgba(255, 0, 0, 1)",
        data: sysData
    }, {
        name: 'DIA',
        color: "rgba(0, 110, 255, 1)",
        data: diaData
    }],
    navigation: {
        menuItemStyle: {
            fontSize: '10px'
        }
    }
  });

  Highcharts.getOptions().plotOptions.pie.colors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[8],
        i;

    for (i = 0; i < 10; i += 1) {
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
  }());

  $('#container2').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
      text: 'Procentowy podział normy wartości ciśnienia skurczowego',
      widthAdjust: -60
    },
    credits: {
    	enabled: false
    },
    tooltip: {
        enabled: true,
        pointFormat: '<b>{point.y}</b>',
    },
    exporting: buttons,
    plotOptions: {
        pie: {
            allowPointSelect: false,
            dataLabels: {
                enabled: true,
                format: '{point.percentage:.1f}% ({point.y})',
                distance: -60
            },
            showInLegend: true
        }
    },
    series: [{
        colorByPoint: true,
        data: [{
            name: 'Poniżej normy',
            y: (sysStats[0]>0) ? sysStats[0] : null
        }, {
            name: 'W normie',
            y: sysStats[1]
        }, {
            name: 'Powyżej normy',
            y: sysStats[2]
        }]
    }]
  });

  Highcharts.getOptions().plotOptions.pie.colors = (function () {
      var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

      for (i = 0; i < 10; i += 1) {
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
      }
      return colors;
  }());

  $('#container3').highcharts({
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Procentowy podział normy wartości ciśnienia rozkurczowego',
      widthAdjust: -60
    },
    credits: {
      enabled: false
    },
    tooltip: {
        enabled: true,
        pointFormat: '<b>{point.y}</b>',
    },
    exporting: buttons,
    plotOptions: {
        pie: {
            allowPointSelect: false,
            dataLabels: {
                enabled: true,
                format: '{point.percentage:.1f}% ({point.y})',
                distance: -60
            },
            showInLegend: true
        }
    },
    series: [{
        colorByPoint: true,
        data: [{
            name: 'Poniżej normy',
            y: (diaStats[0]>0) ? diaStats[0] : null
        }, {
            name: 'W normie',
            y: diaStats[1]
        }, {
            name: 'Powyżej normy',
            y: diaStats[2]
        }]
    }]
  });
});

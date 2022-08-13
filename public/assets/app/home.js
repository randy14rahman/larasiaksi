Highcharts.chart('pie-sm', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: '1183',
        align: 'center',
        verticalAlign: 'middle',
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                // distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            // startAngle: -90,
            // endAngle: 90,
            center: ['50%', '50%'],
            size: '100%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        innerSize: '50%',
        data: [
            ['Proses', 237],
            ['Arsip', 342],
        ]
    }]
});
Highcharts.chart('pie-sk', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: (parseInt(data.surat_keluar.stats.arsip,'')+parseInt(data.surat_keluar.stats.proses||'')),
        align: 'center',
        verticalAlign: 'middle',
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                // distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            // startAngle: -90,
            // endAngle: 90,
            center: ['50%', '50%'],
            size: '100%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Surat Keluar',
        innerSize: '50%',
        data: [
            ['Proses', parseInt(data.surat_keluar.stats.proses,'')],
            ['Arsip', parseInt(data.surat_keluar.stats.arsip,'')],
        ]
    }]
});

Highcharts.chart('bar-jumlah-smsk-pbln', {
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'Trendline Surat Masuk / Surat Keluar',
        align: 'left'
    },
    xAxis: {
        type: 'datetime',
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0"><b>{series.name}</b>: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    legend: {
        enabled: true,
        align: 'right',
        verticalAlign: 'top',
    },
    series: [{
        name: 'Surat Masuk',
        color: '#57AB7D',
        data: []

    }, {
        name: 'Surat Keluar',
        color: '#7176BE',
        data: data.surat_keluar.trendline

    }]
});
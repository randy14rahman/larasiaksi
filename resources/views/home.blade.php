@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row d-none">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Surat Masuk</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pie-sm" style="height: 220px;"></div>    
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-4">
                            <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 35%</span>
                            <h5 class="description-header">105</h5>
                            <span class="description-text">Surat Baru</span>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="description-block border-right">
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 42%</span>
                            <h5 class="description-header">129</h5>
                            <span class="description-text">Disposisi</span>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="description-block">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 23%</span>
                            <h5 class="description-header">73</h5>
                            <span class="description-text">Proses</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Surat Keluar</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pie-sk" style="height: 220px;"></div>    
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-4">
                            <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 13%</span>
                            <h5 class="description-header">32</h5>
                            <span class="description-text">Draft Surat</span>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="description-block border-right">
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 44%</span>
                            <h5 class="description-header">103</h5>
                            <span class="description-text">Paraf/Tanda Tangan</span>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="description-block">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 43%</span>
                            <h5 class="description-header">102</h5>
                            <span class="description-text">Shared</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Surat Masuk</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="bar-jumlah-smsk-pbln" style="height: 210px;"></div>    
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Statistik Surat</h3>
                    </div>
                </div>
                <div class="card-body" style="height: 250px;">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fas fa-inbox"></i><span class="ml-2">Arsip Surat Masuk</span>
                                <span class="badge bg-success float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-envelope"></i><span class="ml-2">Arsip Surat Keluar</span>
                                <span class="badge bg-success float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-file-alt"></i><span class="ml-2">Disposisi Selesai</span>
                                <span class="badge bg-primary float-right">12</span>
                        </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="fas fa-filter"></i><span class="ml-2">Disposisi Proses</span>
                            <span class="badge bg-info float-right">12</span>
                        </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-trash-alt"></i><span class="ml-2">Disposisi Proses > 7 hari</span>
                                <span class="badge bg-danger float-right">12</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop



@push('js')
    <script type="text/javascript" src="{{ asset('vendor/highcharts/highcharts.js') }}"></script>

    <script>
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
                    ['Proses', 307],
                    ['Arsip', 876],
                ]
            }]
        });

        Highcharts.chart('bar-jumlah-smsk-pbln', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
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
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
                enabled: false
            },
            series: [{
                name: 'Surat Masuk',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'Surat Keluar',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }]
        });
    </script>
@endpush
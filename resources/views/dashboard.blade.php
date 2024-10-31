@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
        </div>
        <div class="row" style="display:none;">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Penjualan <i
                                class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">$ 15,0000</h2>
                        <h6 class="card-text"> </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Weekly Orders <i
                                class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">45,6334</h2>
                        <h6 class="card-text">Decreased by 10%</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Visitors Online <i
                                class="mdi mdi-diamond mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">95,5741</h2>
                        <h6 class="card-text">Increased by 5%</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body" style="text-align:center;padding:7rem 2.5rem!important;">
                        <h1 style="font-size:4.5rem!important">SELAMAT DATANG !</h1>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body" style="padding:1rem 2.5rem!important;">
                        <select class="form-control select2" name="tanggal" id="tanggal">
                            <option value="" selected>HARI INI</option>
                            @foreach($tanggal as $item)
                            <option value="{{ $item->created_date }}">{{ $item->created_date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-column-harian"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-column-bulanan"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-pie-bulanan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready( function () {
        $('.select2').select2();
        defaultChartColumnHarian();
        defaultChartColumnBulanan();
        defaultchartPie();
    });

    $('#tanggal').change(function(){
        defaultChartColumnHarian();
        defaultChartColumnBulanan();
        defaultchartPie();
    });

    function defaultChartColumnHarian(){
        var tanggal = $('#tanggal').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.chartColumnHarian') }}",
            data : {tanggal:tanggal},
            success: function(response){
                console.log(response);
                chartColumnHarian(response);
            }
        });
    }
    function chartColumnHarian(response){
        Highcharts.chart('chart-column-harian', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Jumlah Dan Berat Pada Tanggal '+response.tanggal,
                align: 'center'
            },
            xAxis: {
                categories: ['Barang Masuk', 'Barang Keluar', 'Barang Di Gudang'],
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah dan Berat'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
            },
            series: [
                {
                    name: 'Jumlah (pcs)',
                    data: response.jumlah
                },
                {
                    name: 'Berat (Kg)',
                    data: response.berat
                }
            ]
        });

    }

    function defaultChartColumnBulanan(){
        var tanggal = $('#tanggal').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.chartColumnBulanan') }}",
            data : {tanggal:tanggal},
            success: function(response){
                chartColumnBulanan(response);
            }
        });
    }
    function chartColumnBulanan(response){
        Highcharts.chart('chart-column-bulanan', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Jumlah Barang Tiap Bulanan',
                align: 'center'
            },
            xAxis: {
                categories: response.category,
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah (pcs)'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
            },
            series: [
                {
                    name: 'Barang Masuk',
                    data: response.barang_masuk
                },
                {
                    name: 'Barang Keluar',
                    data: response.barang_keluar
                },
                {
                    name: 'Barang Di Gudang',
                    data: response.barang_gudang
                }
            ]
        });

    }
    
    
    function defaultchartPie(){
        var tahun = $('#tahun').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.chartPie') }}",
            data : {tahun:tahun},
            success: function(response){
                console.log(response);
                chartPie(response);
            }
        });
    }
    function chartPie(response){
        Highcharts.chart('chart-pie-bulanan', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Persentase Jumlah dan Berat',
                align: 'center'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Persentase (%)',
                data: response.series
            }]
        });
    }
</script>
@endsection
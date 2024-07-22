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
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body" style="padding:1rem 2.5rem!important;">
                        <select class="form-control select2" name="tahun" id="tahun">
                            @for($Year ; $Year > $startYear ; $Year--)
                            <option value="{{ $Year }}">{{ $Year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-column"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-pie"></div>
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
        defaultChartColumn();
        defaultchartPie();
    });

    $('#tahun').change(function(){
        defaultChartColumn();
        defaultchartPie();
    });
    
    function defaultchartPie(){
        var tahun = $('#tahun').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.chartPie') }}",
            data : {tahun:tahun},
            success: function(response){
                chartPie(response);
            }
        });
    }

    function chartPie(response){
        Highcharts.chart('chart-pie', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Persentase Penjualan Produk Tahun '+response.tahun,
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

    function defaultChartColumn(){
        var tahun = $('#tahun').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('dashboard.chartColumn') }}",
            data : {tahun:tahun},
            success: function(response){
                chartColumn(response);
            }
        });
    }
    function chartColumn(response){
        Highcharts.chart('chart-column',{
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    depth: 50,
                    viewDistance: 25
                }
            },
            xAxis: {
                categories: response.category
            },
            yAxis: {
                title: {
                    enabled: false
                }
            },
            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: 'Jumlah: {point.y}'
            },
            title: {
                text: 'Jumlah Penjualan Produk Tahun '+response.tahun,
                align: 'center'
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                data: response.series,
                colorByPoint: true
            }]
        });
    }
</script>
@endsection
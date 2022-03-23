@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('info'))
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i></strong>
                    {!! session('info') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Grafik Label Service</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Grafik Label Service</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{-- Chart --}}
            <div class="row">
                <div class="col-12 col-md-10">
                    <div class="card card-light">
                        <div class="overlay d-none">
                            <p class="h5"><i class="fas fa-sync-alt fa-spin"></i> Loading...</p>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="form-group col-12 col-sm-2">
                                    <label>Bulan</label>
                                    <select class="form-control" name="bulan" id="bulan">
                                        <option disabled selected value="">Pilih Bulan</option>
                                        @foreach ($bulan as $i => $item)
                                            <option value="{{ $i + 1 }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 350px; height: 350px; max-height: 350px;max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-dark">
                            0
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL SERVICE</span>
                        </div>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            0
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL SERVICE RUTIN</span>
                        </div>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-danger">
                            0
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL SERVICE URGENT</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
@endsection

@section('script')
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var myChart;
            $('#bulan').change(function(e) {
                e.preventDefault();
                var url = "{{ route('chart_label') }}";
                var Total1 = [];
                var Total2 = [];
                var Bulan = [];
                var Title1 = [];
                var Title2 = [];
                $('.overlay').removeClass('d-none');
                $.get(url, {
                    bulan: $(this).val(),
                }, function(response) {
                    $('.overlay').addClass('d-none');
                    $.each(response, function(index, data) {
                        Total1.push(data.total1);
                        Total2.push(data.total2);
                        Bulan.push(data.bulan);
                        Title1.push(data.title1);
                        Title2.push(data.title2);
                        $('div .info-box-icon:eq(0)').text(data.total_semua).fadeIn('slow');
                        $('div .info-box-icon:eq(1)').text(data.total_rutin).fadeIn('slow');
                        $('div .info-box-icon:eq(2)').text(data.total_urgent).fadeIn(
                            'slow');
                    });

                    var areaChartData = {
                        labels: Bulan[0],
                        datasets: [{
                                label: Title1,
                                // backgroundColor: '#28a745',
                                borderColor: '#28a745',
                                // pointRadius: false,
                                pointColor: '#000',
                                // pointBackgroundColor: '#c1c7d1',
                                // pointHighlightFill: '#fff',
                                // pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: Total1[0]
                            },
                            {
                                label: Title2,
                                // backgroundColor: '#dc3545',
                                borderColor: '#dc3545',
                                // pointRadius: false,
                                pointColor: '#000',
                                // pointBackgroundColor: '#c1c7d1',
                                // pointHighlightFill: '#fff',
                                // pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: Total2[0]
                            }
                        ]
                    }
                    //-------------
                    //- BAR CHART -
                    //-------------
                    if (myChart) {
                        myChart.destroy();
                    }
                    var lineChartCanvas = $('#barChart').get(0).getContext('2d');
                    var lineChartData = $.extend(true, {}, areaChartData);
                    var temp0 = areaChartData.datasets[0]
                    var temp1 = areaChartData.datasets[1]
                    lineChartData.datasets[0] = temp0
                    lineChartData.datasets[1] = temp1

                    var lineChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }

                    myChart = new Chart(lineChartCanvas, {
                        type: 'line',
                        data: lineChartData,
                        options: lineChartOptions,
                    });

                });
            });
        });
    </script>
@endsection

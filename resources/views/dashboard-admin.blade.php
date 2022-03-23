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
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-4">
                    <a href="{{ route('customer') }}">
                        <div class="small-box bg-white">
                            <div class="inner">
                                <h3>{{ $cs }}</h3>
                                <p>Customer</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users text-primary2" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="{{ route('upcoming') }}">
                        <div class="small-box bg-white">
                            <div class="inner">
                                <h3>{{ $sr }}</h3>
                                <p>Service Reminder</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bell text-primary2" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="{{ route('booking') }}">
                        <div class="small-box bg-white">
                            <div class="inner">
                                <h3>{{ $bs }}</h3>
                                <p>Booking Service</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-book text-primary2" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.row -->

            {{-- Chart --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Grafik Jumlah Service</h3>
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
            var url = "{{ route('dashboard.chart') }}";
            var Total1 = [];
            var Bulan = [];
            var Title1 = [];
            $.get(url, function(response) {
                $.each(response, function(index, data) {
                    Total1.push(data.total1);
                    Bulan.push(data.bulan);
                    Title1.push(data.title1);
                });

                var areaChartData = {
                    labels: Bulan[0],
                    datasets: [{
                            label: Title1,
                            backgroundColor: '#0a7ee3',
                            borderColor: '#0a7ee3',
                            pointRadius: false,
                            pointColor: '#0a7ee3',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: Total1[0]
                        },

                    ]
                }
                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d');
                var barChartData = $.extend(true, {}, areaChartData);
                var temp0 = areaChartData.datasets[0]
                barChartData.datasets[0] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                });

            });
        });
    </script>
@endsection

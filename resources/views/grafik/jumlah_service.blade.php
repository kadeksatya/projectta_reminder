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
                    <h1 class="m-0 text-dark">Grafik Jumlah Service</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Grafik Jumlah Service</li>
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
                <div class="col-12 col-md-12">
                    <div class="card card-light">
                        <div class="overlay d-none">
                            <p class="h5"><i class="fas fa-sync-alt fa-spin"></i> Loading...</p>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="form-group col-12 col-sm-2">
                                    <label>Pilih Tahun</label>
                                    <select class="form-control" name="tahun" id="tahun">
                                        <option disabled selected value="">Pilih</option>
                                        @foreach (range(2018, 2100) as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
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
            $('#tahun').change(function(e) {
                e.preventDefault();
                var url = "{{ route('chart_jumlah_service') }}";
                var Total = [];
                var Bulan = [];
                var Title = [];
                $('.overlay').removeClass('d-none');
                $.get(url, {
                    tahun: $(this).val()
                }, function(response) {
                    $('.overlay').addClass('d-none');
                    $.each(response, function(index, data) {
                        Total.push(data.total);
                        Bulan.push(data.bulan);
                        Title.push(data.title);
                    });

                    var areaChartData = {
                        labels: Bulan[0],
                        datasets: [{
                                label: Title,
                                backgroundColor: '#0a7ee3',
                                borderColor: '#0a7ee3',
                                pointRadius: false,
                                pointColor: '#0a7ee3',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: Total[0]
                            },

                        ]
                    }
                    //-------------
                    //- BAR CHART -
                    //-------------
                    if (myChart) {
                        myChart.destroy();
                    }
                    var barChartCanvas = $('#barChart').get(0).getContext('2d');
                    var barChartData = $.extend(true, {}, areaChartData);
                    var temp0 = areaChartData.datasets[0]
                    barChartData.datasets[0] = temp0

                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }

                    myChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    });

                });
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Data User')

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('info'))
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i></strong>
                    {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Upcoming Service</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Upcoming Service</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-row align-items-center">
                            <h3 class="card-title mr-auto">List Upcoming Service</h3>
                            <div class="alert alert-info h6 m-0" role="alert">
                                <strong>Info Penting</strong> Data akan tampil otomatis 1 minggu sebelum <strong>tanggal
                                    service
                                    mendatang</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <th>Service Mendatang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="7">
                                            <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>
                                            <span>Loading...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>

@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- JQuery mask -->
    <script src="{{ asset('assets/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script>
        // set up firebase
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            databaseURL: "{{ config('services.firebase.database_url') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        firebase.initializeApp(firebaseConfig);
        let db = firebase.firestore();
        var database = firebase.database();
        var auth = firebase.auth();
        // end firebase
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        $(window).on("load", function() {
            getData();
        });

        // get data 
        function getData() {
            var dataSet = [];
            x = 1
            db.collection("riwayat_service").get().then(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {
                    var uuid = doc.id;
                    var userId = doc.data().userId;
                    // reminder 1 minggu sebelum tanggal service mendatang
                    var datenow = new Date();
                    var date_next = new Date(doc.data().tgl_sm);
                    date_next.setDate(date_next.getDate() - 7);
                    var date_now = datenow.getDate() + '/' + (datenow.getMonth() + 1) + '/' + datenow
                        .getFullYear();
                    var tgl_service_mendatang = date_next.getDate() + '/' + (date_next.getMonth() + 1) +
                        '/' + date_next
                        .getFullYear();
                    // cek tanggal apakah sudah deket 1 minggu 
                    if (datenow.valueOf() >= date_next.valueOf()) {
                        console.log('sudah deket');
                        dataSet.push([
                            x,
                            (doc.data().users == null) ? '-' : doc.data().users[1],
                            (doc.data().users == null) ? '-' : doc.data().users[0],
                            (doc.data().tgl_sm == null) ? '-' : doc.data().tgl_sm,
                        ]);
                    } else {
                        // dataSet.push([
                        //     x,
                        //     (doc.data().users == null) ? '-' : doc.data().users[1],
                        //     (doc.data().users == null) ? '-' : doc.data().users[0],
                        //     (doc.data().tgl_sm == null) ? '-' : tgl_service_mendatang,
                        // ]);
                        // alert('belum waktunya');
                    }
                    x++
                });
                $('table').DataTable({
                    "data": dataSet,
                    "bDestroy": true,
                });
            });
        }

        $(document).ready(function() {

        });
    </script>
@endsection

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
                    <h1 class="m-0 text-dark">Booking Service</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Booking Service</li>
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
                            <h3 class="card-title">List Booking Service</h3>
                            {{-- <button class="btn btn-primary ml-auto" id="tambah">Tambah</button> --}}
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>Tgl Book</th>
                                        <th>Label</th>
                                        <th>Jenis Filter</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="9">
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

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="modalForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="up_password" id="up_password" class="form-control" value="no">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">NoHp</label>
                                    <input type="text" name="noHp" id="noHp" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Jenis Mesin</label>
                                    <select name="jenis_mesin" id="jenis_mesin" multiple="multiple" class="form-control"
                                        data-placeholder="- Select -">
                                        <option value="Aqualife RO 100 Gpd">Aqualife RO 100 Gpd</option>
                                        <option value="Aqualife RO 400 Gpd">Aqualife RO 400 Gpd</option>
                                        <option value="Aqualife RO Cabinet 100 Gpd">Aqualife RO Cabinet 100 Gpd</option>
                                        <option value="Aqualife RO Dispenser 100 Gpd">Aqualife RO Dispenser 100 Gpd</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="text" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            db.collection("booking_service").get().then(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {
                    var uuid = doc.id;
                    var status = "";
                    var btn = "";
                    if (doc.data().status == "waiting") {
                        status = '<span class="badge badge-warning p-2">Menunggu konfirmasi</span>';
                        btn +=
                            '<button class="btn btn-sm btn-primary" title="konfirmasi" id="konfirmasi" data-id="' +
                            uuid +
                            '"><i class="fas fa-check"></i></button>' +
                            '<button class="btn btn-sm btn-danger mx-1" title="tolak" id="tolak" data-id="' +
                            uuid +
                            '"><i class="fa fa-window-close" aria-hidden="true"></i></button>';
                    } else if (doc.data().status == "confirmed") {
                        status = '<span class="badge badge-success p-2">Terkonfirmasi</span>';
                        btn += '-';
                    } else {
                        status = '<span class="badge badge-danger p-2">Menolak</span>';
                        btn += '-';
                    }

                    dataSet.push([
                        x,
                        (doc.data().users == null) ? '-' : doc.data().users[1],
                        (doc.data().users == null) ? '-' : doc.data().users[0],
                        (doc.data().tgl_book == null) ? '-' : doc.data().tgl_book,
                        (doc.data().label_service == null) ? '-' : doc.data().label_service,
                        (doc.data().jenis_filter == null) ? '-' : doc.data().jenis_filter,
                        (doc.data().keluhan == null) ? '-' : doc.data().keluhan,
                        (doc.data().status == null) ? '-' : status,
                        btn,
                    ]);
                    x++
                });
                $('table').DataTable({
                    "data": dataSet,
                    "bDestroy": true,
                });
            });
        }

        $(document).ready(function() {
            $('#jenis_mesin').select2({
                theme: 'bootstrap4',
                maximumSelectionSize: 4,
                placeholder: function() {
                    $(this).data('placeholder');
                }
            })

            // open modal tambah
            $('#tambah').click(function(e) {
                e.preventDefault();
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Tambah');
                $('#modal form').find('#password').closest('.form-group').show();
            });

            // reset all input in form after clicking modal
            $('#modal').on('hidden.bs.modal', function(e) {
                validator.resetForm();
                $("#modalForm").find('.is-invalid').removeClass('is-invalid');
                $(this)
                    .find("input,textarea,select")
                    .not('#id,input[name="_token"]')
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
                $('#modal form').find('#id').val('');
            });

            // konfirmasi
            $('table').on("click", "#konfirmasi", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var userId = $(this).data('userId');
                if (confirm('Anda yakin untuk konfirmasi booking service ini ?')) {
                    const snapshot = db.collection('booking_service').doc(id);
                    snapshot.get().then((doc) => {
                        if (doc.exists) {
                            var data = doc.data();
                            var jenis_filter = [];
                            for (let i = 0; i < data.jenis_filter.length; i++) {
                                const element = data.jenis_filter[i];
                                jenis_filter.push(element);
                            }
                            // update to firestore
                            db.collection("booking_service").doc(id).update({
                                status: 'confirmed',
                            });
                            // insert ke riwayat_services
                            db.collection("riwayat_service").add({
                                    tgl_service: data.tgl_service,
                                    durasi: '',
                                    tgl_sm: '',
                                    label_service: data.label_service,
                                    jenis_filter: jenis_filter,
                                    jenis_mesin: '',
                                    catatan: data.keluhan,
                                    userId: data.userId,
                                    users: [
                                        data.users[0],
                                        data.users[1]
                                    ],
                                })
                                .then(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success Confirm!',
                                        showConfirmButton: false,
                                        timer: 1000,
                                    }).then((result) => {
                                        getData();
                                        $('#modal').modal('hide');
                                    })
                                });
                        }
                    }).catch((error) => {
                        console.log("Error getting document:", error);
                    });
                }
            });

            // tolak
            $('table').on("click", "#tolak", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                if (confirm('Anda yakin untuk menolak booking service ini ?')) {
                    Swal.fire({
                        title: 'Masukan Alasan Menolak',
                        input: 'textarea',
                        confirmButtonText: 'Simpan!'
                    }).then(function(result) {
                        if (!result.value) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Harap mengisi alasan!'
                            });
                        } else {
                            db.collection("booking_service").doc(id).update({
                                    status: 'reject',
                                    reason_to_refuse: result.value,
                                })
                                .then(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success Reject!',
                                        showConfirmButton: false,
                                        timer: 1000,
                                    }).then((result) => {
                                        getData();
                                    })
                                });
                        }
                    })
                }
            });
        });
    </script>
@endsection

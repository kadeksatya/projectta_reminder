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
                    <h1 class="m-0 text-dark">Customer</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
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
                            <h3 class="card-title">List Customer</h3>
                            <button class="btn btn-primary ml-auto" id="tambah">Tambah</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Jenis Filter</th>
                                        <th>Jenis Mesin</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="8">
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
                                    <label for="">Jenis Filter</label>
                                    <select name="jenis_filter" id="jenis_filter" multiple="multiple" class="form-control"
                                        data-placeholder="- Select -">
                                        <option value="Filter 10 inch 5 micron">Filter 10 inch 5 micron</option>
                                        <option value="Filter 10 inch 1 micron">Filter 10 inch 1 micron</option>
                                        <option value="Filter 10 inch OCB/GAC">Filter 10 inch OCB/GAC</option>
                                        <option value="Filter 20 inch 5 micron">Filter 20 inch 5 micron</option>
                                        <option value="Filter 20 inch 1 micron">Filter 20 inch 1 micron</option>
                                        <option value="Filter 20 inch OCB/GAC">Filter 20 inch OCB/GAC</option>
                                    </select>
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
            db.collection("users").get().then(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {
                    var uuid = doc.id;
                    dataSet.push([
                        x,
                        (doc.data().nama == null) ? '-' : doc.data().nama,
                        (doc.data().username == null) ? '-' : doc.data().username,
                        (doc.data().email == null) ? '-' : doc.data().email,
                        (doc.data().alamat == null) ? '-' : doc.data().alamat,
                        (doc.data().jenis_filter == null) ? '-' : doc.data().jenis_filter,
                        (doc.data().jenis_mesin == null) ? '-' : doc.data().jenis_mesin,
                        '<button class="btn btn-sm btn-success" id="edit" data-id="' +
                        uuid +
                        '"><i class="fas fa-edit"></i></button>' +
                        ' <a class="btn btn-sm btn-dark" href="customer/riwayat/' +
                        uuid +
                        '"><i class="fas fa-list"></i> riwayat</a>',
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
            $('#jenis_filter, #jenis_mesin').select2({
                theme: 'bootstrap4',
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
                $('#jenis_filter, #jenis_mesin').val([]).change();
            });

            // open modal edit
            $('table').on("click", "#edit", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Edit');
                $('#modal form').find('#id').val(id);
                $('#modal form').find('#password').closest('.form-group').hide();
                db.collection("users").doc(id)
                    .onSnapshot((doc) => {
                        var data = doc.data();
                        $('#modal form').find('#nama').val(data.nama);
                        $('#modal form').find('#email').val(data.email);
                        $('#modal form').find('#noHp').val(data.noHp);
                        $('#modal form').find('#jenis_filter').val(data.jenis_filter)
                            .change();
                        $('#modal form').find('#jenis_mesin').val(data.jenis_mesin)
                            .change();
                        $('#modal form').find('#alamat').val(data.alamat);
                        $('#modal form').find('#username').val(data.username);
                    });
            });

            // tambah data
            var validator = $("#modalForm").validate({
                rules: {
                    nama: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    noHp: {
                        required: true,
                    },
                    jenis_filter: {
                        required: true,
                    },
                    jenis_mesin: {
                        required: true,
                    },
                    alamat: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    password: {
                        required: function() {
                            return ($('form').find('#id').val() == "");
                        },
                        minlength: 5
                    },
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group, .form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    var id = $(form).find('#id').val();
                    var dataArray = $(form).serializeArray();
                    var dataObj = {};
                    $(dataArray).each(function(i, field) {
                        dataObj[field.name] = field.value;
                    });
                    $(form).find('[type="submit"]').addClass('disabled').text('Loading...');
                    if (id == "") {
                        // create account
                        firebase.auth().createUserWithEmailAndPassword(dataObj['email'],
                                dataObj['password'])
                            .then(function(data) {
                                var user = data.user;
                                // insert to firestore
                                db.collection("users").doc(user.uid).set({
                                        nama: dataObj['nama'],
                                        username: dataObj['username'],
                                        email: dataObj['email'],
                                        noHp: dataObj['noHp'],
                                        jenis_filter: $('#jenis_filter').select2("val"),
                                        jenis_mesin: $('#jenis_mesin').select2("val"),
                                        alamat: dataObj['alamat'],
                                    })
                                    .then(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Successfully!',
                                            showConfirmButton: false,
                                            timer: 1000,
                                        }).then((result) => {
                                            getData();
                                            $('#modal').modal('hide');
                                        })
                                    });
                            })
                            .catch((error) => {
                                var errorCode = error.code;
                                var errorMessage = error.message;
                                Swal.fire({
                                    icon: 'error',
                                    title: errorMessage,
                                    showConfirmButton: true,
                                }).then((result) => {
                                    $('#modal').find('#password').val('');
                                })
                            });
                        $(form).find('[type="submit"]').removeClass('disabled')
                            .text('Simpan');
                    } else {
                        // update users in riwayat service
                        db.collection("riwayat_service")
                            .where("userId", "==", id)
                            .get()
                            .then(function(querySnapshot) {
                                querySnapshot.forEach(function(document) {
                                    document.ref.update({
                                        users: [
                                            dataObj['nama'],
                                            dataObj['email']
                                        ]
                                    });
                                });
                            });

                        // update users in booking service
                        db.collection("booking_service")
                            .where("userId", "==", id)
                            .get()
                            .then(function(querySnapshot) {
                                querySnapshot.forEach(function(document) {
                                    document.ref.update({
                                        users: [
                                            dataObj['nama'],
                                            dataObj['email']
                                        ]
                                    });
                                });
                            });

                        // update users
                        db.collection("users").doc(id).update({
                                nama: dataObj['nama'],
                                username: dataObj['username'],
                                email: dataObj['email'],
                                noHp: dataObj['noHp'],
                                jenis_filter: $('#jenis_filter').select2("val"),
                                jenis_mesin: $('#jenis_mesin').select2("val"),
                                alamat: dataObj['alamat'],
                            })
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully Updated!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                }).then((result) => {
                                    getData();
                                    $('#modal').modal('hide');
                                })
                            });
                        $(form).find('[type="submit"]').removeClass('disabled')
                            .text('Simpan');
                    }
                }
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Data User')

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
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
                    <h1 class="m-0 text-dark">E-Katalog</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">E-Katalog</li>
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
                            <h3 class="card-title">List E-Katalog</h3>
                            <button class="btn btn-primary ml-auto" id="tambah">Tambah</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Katalog</th>
                                        <th>File</th>
                                        <th>Opsi</th>
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
                <form action="" id="modalForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="up_password" id="up_password" class="form-control" value="no">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Jenis Katalog</label>
                                    <select name="jenis" id="jenis" class="form-control">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="produk">Produk</option>
                                        <option value="filter">Filter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">File Katalog</label>
                                    <input type="hidden" name="fileold" id="fileold">
                                    <input type="file" name="file" id="file" accept="application/pdf"
                                        class="form-control">
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
            db.collection("katalog").get().then(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {
                    var uuid = doc.id;
                    var pdf = (doc.data().file == null) ? '-' : doc.data().file;
                    dataSet.push([
                        x,
                        (doc.data().jenis == null) ? '-' : doc.data().jenis,
                        '<a href="katalog/' + pdf +
                        '" class="btn btn-danger btn-sm" target="_blank">PDF</a>',
                        '<button class="btn btn-sm btn-success" id="edit" data-id="' +
                        uuid +
                        '"><i class="fas fa-edit"></i></button>',
                    ]);
                    x++
                });
                $('table').DataTable({
                    "data": dataSet,
                    "bDestroy": true,
                });
            });
        }

        async function cek(jenis = null) {
            const cek = await db.collection("katalog").where("jenis", "==", jenis)
                .get();
            return cek.empty;
        }

        $(document).ready(function() {
            // open modal tambah
            $('#tambah').click(function(e) {
                e.preventDefault();
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Tambah');
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

            // open modal edit
            $('table').on("click", "#edit", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Edit');
                $('#modal form').find('#id').val(id);
                db.collection("katalog").doc(id)
                    .onSnapshot((doc) => {
                        var data = doc.data();
                        $('#modal form').find('#fileold').val(data.file);
                        $('#modal form').find('#jenis').val(data.jenis)
                            .change();
                        // $('#modal form').find('#file').val(data.file);
                    });
            });

            // tambah data
            var validator = $("#modalForm").validate({
                rules: {
                    jenis: {
                        required: true,
                    },
                    file: {
                        required: function() {
                            return ($('form').find('#id').val() == "");
                        },
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
                        // hitung jml data
                        db.collection("katalog").get().then(snap => {
                            if (snap.size == 2) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Tidak bisa menambah data lagi!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#modal').modal('hide');
                            } else {
                                // cek jenis sudah ada
                                db.collection("katalog").where("jenis", "==", dataObj['jenis'])
                                    .get()
                                    .then((querySnapshot) => {
                                        if (querySnapshot.size) {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Data sudah ada!',
                                                showConfirmButton: false,
                                                timer: 1000,
                                            })
                                        } else {
                                            // upload file
                                            $.ajax({
                                                url: "{{ route('upload.katalog') }}",
                                                type: "POST",
                                                dataType: "JSON",
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                data: new FormData(form),
                                                success: function(response) {
                                                    var file = response
                                                        .filename;
                                                    // insert to firestore
                                                    db.collection("katalog")
                                                        .add({
                                                            jenis: dataObj[
                                                                'jenis'
                                                            ],
                                                            file: file,
                                                        })
                                                        .then(() => {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Successfully!',
                                                                showConfirmButton: false,
                                                                timer: 1000,
                                                            }).then((
                                                                result
                                                            ) => {
                                                                getData
                                                                    ();
                                                                $('#modal')
                                                                    .modal(
                                                                        'hide'
                                                                    );
                                                            })
                                                        });
                                                },
                                                error: function(response) {
                                                    console.log(response);
                                                }
                                            });
                                        }
                                    })
                            }
                        });
                        $(form).find('[type="submit"]').removeClass('disabled')
                            .text('Simpan');
                    } else {
                        $.ajax({
                            url: "{{ route('upload.katalog') }}",
                            type: "POST",
                            dataType: "JSON",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: new FormData(form),
                            success: function(response) {
                                var file = response.filename;
                                // insert to firestore
                                db.collection("katalog").doc(id).update({
                                        jenis: dataObj['jenis'],
                                        file: file,
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
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                        $(form).find('[type="submit"]').removeClass('disabled')
                            .text('Simpan');
                    }
                }
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Data User')

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                            <h3 class="card-title">Riwayat {{ $nama }}</h3>
                            <a href="{{ route('customer') }}" class="btn btn-danger mx-1 ml-auto"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                            <button class="btn btn-primary" id="tambah">Tambah</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl Service</th>
                                        <th>Durasi</th>
                                        <th>Tgl Service Mendatang</th>
                                        <th>Label Service</th>
                                        <th>Jenis Filter</th>
                                        <th>Catatan</th>
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
                                    <label for="">Tanggal Service</label>
                                    <input type="date" name="tgl_service" id="tgl_service" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Durasi</label>
                                    <select name="durasi" id="durasi" class="form-control">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="1">1 Bulan</option>
                                        <option value="2">2 Bulan</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="4">4 Bulan</option>
                                        <option value="5">5 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Label Service</label>
                                    <select name="label_service" id="label_service" class="form-control">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="rutin">Service rutin</option>
                                        <option value="urgent">Service urgent</option>
                                    </select>
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
                                    <label for="">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control"></textarea>
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

        // global variable
        var userId = "{{ $uid }}";
        var nama = "{{ $nama }}";
        var email = "{{ $email }}";

        // get data 
        function getData() {
            var dataSet = [];
            x = 1
            db.collection("riwayat_service").where('userId', '==', userId).get()
                .then(function(querySnapshot) {
                    querySnapshot.forEach(function(doc) {
                        var uuid = doc.id;
                        dataSet.push([
                            x,
                            (doc.data().tgl_service == null) ? '-' : doc.data().tgl_service,
                            (doc.data().durasi == null) ? '-' : doc.data().durasi + ' Bulan',
                            (doc.data().tgl_sm == null) ? '-' : doc.data().tgl_sm,
                            (doc.data().label_service == null) ? '-' : (doc.data().label_service ==
                                "rutin") ? '<span class="badge badge-pill badge-success">' + doc.data()
                            .label_service + '</span>' :
                            '<span class="badge badge-pill badge-danger">' + doc.data()
                            .label_service + '</span>',
                            (doc.data().jenis_filter == null) ? '-' : doc.data().jenis_filter,
                            (doc.data().catatan == null) ? '-' : doc.data().catatan,
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

        format = function date2str(x, y) {
            var z = {
                M: x.getMonth() + 1,
                d: x.getDate(),
                h: x.getHours(),
                m: x.getMinutes(),
                s: x.getSeconds()
            };
            y = y.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
                return ((v.length > 1 ? "0" : "") + z[v.slice(-1)]).slice(-2)
            });

            return y.replace(/(y+)/g, function(v) {
                return x.getFullYear().toString().slice(-v.length)
            });
        }

        $(document).ready(function() {
            $('#jenis_filter, #jenis_mesin').select2({
                theme: 'bootstrap4',
                placeholder: function() {
                    $(this).data('placeholder');
                }
            });

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
                $('#jenis_filter, #jenis_mesin').val([]).change();
            });

            // open modal edit
            $('table').on("click", "#edit", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Edit');
                $('#modal form').find('#id').val(id);
                db.collection("riwayat_service").doc(id)
                    .onSnapshot((doc) => {
                        var data = doc.data();
                        $('#modal form').find('#tgl_service').val(data.tgl_service);
                        $('#modal form').find('#durasi').val(data.durasi);
                        $('#modal form').find('#label_service').val(data.label_service);
                        $('#modal form').find('#jenis_filter').val(data.jenis_filter).change();
                        $('#modal form').find('#jenis_mesin').val(data.jenis_mesin).change();
                        $('#modal form').find('#catatan').val(data.catatan);
                    });
            });

            // detail
            $('table').on("click", "#detail", function(e) {
                e.preventDefault();
                $('#modaldetail').modal('show');
                $('#modaldetail').find('#email_v').val($(this).data('email'));
                $('#modaldetail').find('#tgl_v').val($(this).data('tgl'));
                $('#modaldetail').find('#usia_v').val($(this).data('usia'));
                $('#modaldetail').find('#alamat_v').val($(this).data('alamat'));
            });

            // tambah data
            var validator = $("#modalForm").validate({
                rules: {
                    tgl_service: {
                        required: true,
                    },
                    durasi: {
                        required: true,
                    },
                    tgl_sm: {
                        required: true,
                    },
                    label_service: {
                        required: true,
                    },
                    jenis_filter: {
                        required: true,
                    },
                    jenis_mesin: {
                        required: true,
                    },
                    catatan: {
                        required: true,
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
                    // tanggal mendatang
                    var now = new Date(dataObj['tgl_service']);
                    newdate = format(new Date(now.getFullYear(), now.getMonth() + parseInt(dataObj[
                                'durasi']),
                            now.getDate()),
                        'yyyy-MM-dd');
                    if (id == "") {
                        // insert to firestore
                        db.collection("riwayat_service").add({
                                tgl_service: dataObj['tgl_service'],
                                durasi: dataObj['durasi'],
                                tgl_sm: newdate,
                                label_service: dataObj['label_service'],
                                jenis_filter: $('#jenis_filter').select2("val"),
                                jenis_mesin: $('#jenis_mesin').select2("val"),
                                catatan: dataObj['catatan'],
                                userId: userId,
                                users: [
                                    nama, email
                                ],
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
                        $(form).find('[type="submit"]').removeClass('disabled')
                            .text('Simpan');
                    } else {
                        db.collection("riwayat_service").doc(id).update({
                                tgl_service: dataObj['tgl_service'],
                                durasi: dataObj['durasi'],
                                tgl_sm: newdate,
                                label_service: dataObj['label_service'],
                                jenis_filter: $('#jenis_filter').select2("val"),
                                jenis_mesin: $('#jenis_mesin').select2("val"),
                                catatan: dataObj['catatan'],
                                userId: userId,
                                users: [
                                    nama, email
                                ],
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

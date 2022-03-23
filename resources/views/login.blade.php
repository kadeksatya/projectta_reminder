<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login - {{ Str::title('Sistem Informasi Service Reminder Pada Aqualife Bali') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/dist/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/dist/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/dist/img/favicon-16x16.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .login-page {
            background-image: linear-gradient(to bottom, rgb(0 0 0 / 90%), hsl(0deg 0% 0% / 82%)), url(assets/dist/img/bg.png);
            background-size: cover;
            background-position: center, right bottom;
            background-repeat: no-repeat, no-repeat;
        }

        .login-box {
            z-index: 9;
        }

    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo text-center mb-5">
            <a href="{{ url('/login') }}">
                <img src="{{ asset('assets/dist/img/logo.png') }}" class="img-fluid p-3" width="150" alt="">
            </a>
            <h5 class="text-white">{{ Str::title('SISTEM INFORMASI SERVICE REMINDER PADA AQUALIFE BALI') }}
            </h5>

        </div>
        <!-- /.login-logo -->
        @if (session('info'))
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i></strong>
                {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h6 class="m-0 text-white">Silahkan login menggunakan akun anda</h6>
            </div>
            <div class="card-body">
                <form action=" {{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value=""
                            autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-dark btn-block">
                                LOGIN</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script type="module">
        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.6.8/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/9.6.8/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyBLT4EEH4scH7SAYlz6oTwv2YdIF8-jBug",
            authDomain: "coba-ab25e.firebaseapp.com",
            projectId: "coba-ab25e",
            storageBucket: "coba-ab25e.appspot.com",
            messagingSenderId: "931794543369",
            appId: "1:931794543369:web:90260e4d7d69e6121ca9d8",
            measurementId: "G-MNH4JJ2RP0"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
    </script>
    <script type="text/javascript">
        $.validator.setDefaults({
            submitHandler: function() {
                var email = $("#email").val();
                var password = $("#password").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    dataType: "JSON",
                    cache: false,
                    data: {
                        "email": email,
                        "password": password,
                        "_token": token
                    },
                    beforeSend: function() {
                        $('form button[type="submit"]').attr('disabled', true).text('Loading...');
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    timer: 800,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                })
                                .then(function() {
                                    window.location.href = "{{ url('dashboard') }}";
                                });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                                text: 'periksa kembali'
                            });
                        }
                        $('form button[type="submit"]').attr('disabled', false).text('LOGIN');

                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });
                        console.log(response);
                        $('form button[type="submit"]').attr('disabled', false).text('LOGIN');

                    }

                });
            }
        });

        $(document).ready(function() {
            $("form").validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                },
                messages: {
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
</body>

</html>

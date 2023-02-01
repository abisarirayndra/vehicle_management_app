<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Vehicle Management App</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="icon" type="image/png" class="rounded-circle" href="{{asset('icons/car.png')}}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('admin/plugins/toastr/toastr.min.css')}}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card-header text-center">
                <img src="{{asset('icons/car.png')}}" alt="AdminLTE Logo" class="brand-image"
                    width="125px" height="auto" style="opacity: .8;">
                    <br>
                    <b style="font-size:23px;">Vehicle Management</b>
            </div>
        <div class="card card-outline card-primary">

            <div class="card-body">
                <p class="login-box-msg" style="font-size:20px"><b>Login</b></p>
                @if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        <p>{{ session()->get('errors') }}</p>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        <p>{{ session()->get('success') }}</p>
                    </div>
                @endif
                <form action="{{ route('login.upload') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required name="email" id="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" required name="password" id="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <!-- /.col -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('reset_password') }}">Lupa Password</a>
                </p>
                <p class="mb-1">
                    <a href="{{ route('register') }}">Register Account</a>
                </p>
                {{-- <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center">Register Buswangi</a>
                </p> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- <button type="button" class="btn btn-success swalDefaultSuccess">
                  Launch Success Toast
                </button> -->
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{asset('admin/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>

    <script>
        @if(session()->has('message'))
        $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
        //  $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        icon: 'success',
        title: "{session()->get('message')}}"
      })
      // });
    });
    @endif
    </script>
</body>

</html>

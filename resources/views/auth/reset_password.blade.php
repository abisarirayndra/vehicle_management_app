<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password Vehicle Management App</title>

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
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="text-center">
            <img src="{{asset('icons/car.png')}}" alt="Vehicle Logo" class="brand-image img-circle"
                width="125px" height="auto" style="opacity: .8;">
            <br>
            <b style="font-size:23px;">Vehicle Management App</b>
        </div>
        <div class="card card-outline card-primary">
            <!-- <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
    </div> -->
            <div class="card-body">
                <p class="login-box-msg">Lupa Password</p>
                @if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        <p>{{ session()->get('errors') }}</p>
                    </div>
                @endif
                <form action="{{ route('reset_password.upload') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password Baru">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                          </div>
                        </div>
                      </div>
                      <div class="input-group mb-3">
                        <input type="password" class="form-control" name="ulangi_password" id="ulangi_password" placeholder="Retype Password Baru">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                          </div>
                        </div>

                      </div>
                      <small id='message'></small>
                    <div class="row">
                        <div class="col-12">
                            <button id="button" type="submit" class="btn btn-primary btn-block">Change Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{route('login')}}">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<script type="text/javascript">
    $('#password_baru, #ulangi_password_baru').on('keyup', function () {
          if ($('#password_baru').val() == $('#ulangi_password_baru').val()) {
            $('#message').html('Password Cocok').css('color', 'green');
            $('#button').removeAttr("disabled");
          } else {
            $('#message').html('Password Tidak Cocok').css('color', 'red');
            var element = document.getElementById('button');
            element.setAttribute('disabled','disabled');
          }

        });
  </script>
</body>

</html>

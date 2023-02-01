<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Vehicle Management App</title>

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

<body class="hold-transition register-page">
    <div class="register-box">
      <div class="text-center">
        <img src="{{asset('icons/car.png')}}" alt="Vehicle Logo" class="brand-image img-circle"
            width="125px" height="auto" style="opacity: .8;">
        <br>
        <b style="font-size:23px;">Vehicle Management App</b>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-body">
            <p class="login-box-msg" style="font-size:20px"><b>Register</b></p>
                @if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        <p>{{ session()->get('errors') }}</p>
                    </div>
                @endif
                <form action="{{ route('register.upload') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <select name="role_id" id="role_id" class="form-control" required>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->role }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" required name="name" id="name" placeholder="Full Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required name="email" id="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" required name="phone_number" id="phone_number" placeholder="Phone Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control" required name="address" id="address" placeholder="Address"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-address-card"></span>
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
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" required name="ulang_password" id="confirm_password" placeholder="Retype password">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small id='message'></small>
                    <div class="col-md-12 text-center">
                        <!-- <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div> -->
                        <!-- /.col -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary" id="button">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="mt-3">
                    <a href="{{route('login')}}" class="text-center">Already Have an Account ? Go, Login</a>
                </div>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
    <script type="text/javascript">
        $('#password, #confirm_password').on('keyup', function () {
              if ($('#password').val() == $('#confirm_password').val()) {
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

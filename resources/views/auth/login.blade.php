<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('gambar/sistem/pavicon.png') }}">

    <link href="{{ asset('asset_admin/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">

    <link href="{{ asset('asset_admin/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

</head>

<body>
    <style type="text/css">
        body{
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            transition: all .1s ease; 
        }


        @keyframes gradient {
          0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
</style>
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>

<div class="login-form-bg h-100 mt-5">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-4">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5 pb-5">

                            <div class="text-center mb-5">
                                <img src="{{ asset('gambar/sistem/logo1.png')}}" alt="" style="height: 100px"> 
                                <h3 class=" mt-2">LARA<b>DUIT</b></h3>
                                <h4 class="mt-4">Sistem Informasi Keuangan <br> Laravel</h4>
                            </div>

                            <h4>Login</h4>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <div class="form-group has-feedback">
                                        <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group has-feedback">
                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('LOGIN') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/custom.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/settings.js') }}"></script>
<script src="{{ asset('asset_admin/js/gleek.js') }}"></script>
<script src="{{ asset('asset_admin/js/styleSwitcher.js') }}"></script>

</body>
</html>
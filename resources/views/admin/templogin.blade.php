<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('template/admin_template/assets/images/favicon.png')}}">
    <title>Digital Tools BD</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('template/admin_template/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('template/admin_template/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('template/admin_template/css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        html{
            background-color: #EFF6F1 ;
            padding: 0px;
            margin: 0px;
        }
    </style>

</head>

<body style="background-color: #EFF6F1 ;">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" class="login-register login-sidebar" style="background-image:url({{asset('template/admin_template/assets/images/sign-in.png')}}); background-size: 80%; background-position: -73px">
    <div class="row">
        <div class="col-md-7 col-lg-7 col-sm-6 col-xs-12">

        </div>
        <div class="col-md-5 col-lg-5 col-sm-6 col-xs-12">
            <div class="vh-100 card p-md-5 p-md-10 p-xs-1">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-center"><img src="{{asset('template/admin_template/assets/images/logo-square.png')}}" alt="homepage" class="dark-logo" /></div>
                    <form method="POST" action="{{ route('tempAuthenticate') }}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="password" class="">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                            @endif
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn   btn-block text-uppercase waves-effect waves-light my-4" style="background: #4DBC60; color: #FFFFFF" type="submit">Log In</button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>Don't have an account? <a href="{{route('register')}}" class="text-success m-l-5"><b>Sign Up</b></a></p>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" action="index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<script src="{{asset('template/admin_template/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('template/admin_template/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('template/admin_template/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('template/admin_template/js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('template/admin_template/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{asset('template/admin_template/js/sidebarmenu.js')}}"></script>
<!--stickey kit -->
<script src="{{asset('template/admin_template/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
<script src="{{asset('template/admin_template/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('template/admin_template/js/custom.min.js')}}"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{asset('template/admin_template/assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
</body>

</html>

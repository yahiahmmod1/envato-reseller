<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Tarique Mosharraf Mobile : +88 01837664478 email: applandsys@gmail.com , Linkedin: https://www.linkedin.com/in/tarique-mosharraf-4092801b7/">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('template/admin_template/assets/images/favicon.png')}}">
    <title>{{ config('app.name', 'Digital Tools BD') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('template/admin_template/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{asset('template/admin_template/assets/plugins/morrisjs/morris.css')}}" rel="stylesheet">
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
        .sidebar-nav>ul>li>a.active {
            font-weight: 400;
            background: #e1f7e6;
            color: #000000;
        }

        .brand-logo{
            margin-top: 10px;
            margin-bottom: 0px;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border: 0;
            border-radius: 0.25em;
            background: initial;
            background-color: #F27474;
            color: #fff;
            font-size: 1em;
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border" style="background: #EFF6F1">
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
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header" style="overflow: hidden">
                <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                    <!-- Logo icon --><b>
                        <img src="{{asset('template/admin_template/assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo brand-logo" />
                        <!-- Light Logo icon -->
                        <img src="{{asset('template/admin_template/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo" />
                    </b>
                <span>
                  <img src="{{asset('template/admin_template/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo" /></span> </a>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto mt-md-0">
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                </ul>
                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                        <form class="app-search">
                            <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/users/1.jpg')}}" alt="user" class="profile-pic" /></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="{{asset('template/admin_template/assets/images/users/1.jpg')}}" alt="user"></div>
                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p><a href="/" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                          onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <i class="fa fa-power-off"></i>   {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    @include('panel.main.sidebar')
    <div class="page-wrapper">
       @yield('breadchrumb')

        @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="alert alert-danger"> {{$errors->first()}}   <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>
                </div>
            </div>
        </div>
        @endif

        @if (session('status'))
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="alert alert-success">   {{ session('status') }}   <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>
                    </div>
                </div>
            </div>
        @endif

      @yield('content')
        <footer class="footer">
            © 2024 All Right Reserved.
        </footer>
    </div>
</div>


<div class="modal fade" id="licenseKeyModal" tabindex="-1" role="dialog" aria-labelledby="licenseKeyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Service Activation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="license-key-form" action="{{route('activation.process')}}" method="POST" accept-charset="UTF-8">
                    @csrf
                    <div class="form-group">
                        <label for="license-key" class="control-label">Enter your license key, you've received via email.</label>
                        <input name="license_key" type="text" class="form-control" id="licesnse_key">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('license-key-form').submit()">Activate</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
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
<!--Custom JavaScript -->
<script src="{{asset('template/admin_template/js/custom.min.js')}}"></script>
<script src="{{asset('template/admin_template/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!--morris JavaScript -->
<script src="{{asset('template/admin_template/assets/plugins/raphael/raphael-min.js')}}"></script>

<!-- ============================================================== -->
<script src="{{asset('template/admin_template/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

@stack('custom-scripts')
</body>

</html>

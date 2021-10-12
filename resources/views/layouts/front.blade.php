<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
@yield('title')
<!-- ===== Bootstrap CSS ===== -->
    <link href="/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <!-- ===== Animation CSS ===== -->
    <link href="/assets/css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/front-style.css" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="/assets/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
    import swal from 'https://unpkg.com/sweetalert/dist/sweetalert.min.js';
    </script>
    <![endif]-->
    @yield('header-css')
    @yield('header-js')
</head>

<body>

<div>
    <!-- ===== Top-Navigation ===== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-bars"></i>
            </a>
            <div class="top-left-part">
                <a class="logo" href="/">
                    <b>
                        <img src="../plugins/images/logo.png" alt="home" />
                    </b>
                    <span>
                            <img src="../plugins/images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                </a>
            </div>
            <div>
                <ul class="nav navbar-top-links navbar-left">
                    <li>
                        <a href="/" class="font-20 waves-effect waves-light"><i class="icon-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="/" class="font-20 waves-effect waves-light"><i class="icon-user"></i> Doctors</a>
                    </li>
                    <li>
                        <a href="/" class="font-20 waves-effect waves-light"><i class="icon-map"></i> Clinics</a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-top-links navbar-right pull-right">
                @if(!session()->has('user_id'))
                    <li>
                        <a class="dropdown-toggle waves-effect waves-light font-20" href="{{route('auth.register')}}">
                            <i class="icon-user-follow"></i>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-toggle waves-effect waves-light font-20" href="/login">
                            <i class="icon-arrow-right-circle"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="dropdown-toggle waves-effect waves-light font-20" href="/dashboard">
                            <i class="icon-briefcase"></i>
                        </a>
                    </li>
                @endif


                    <li class="right-side-toggle">
                        @if(session()->has('user_id'))
                        <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="{{route('auth.logout')}}">
                            <i class="icon-close"></i>
                        </a>
                        @endif
                    </li>

            </ul>

        </div>
    </nav>
    <!-- ===== Top-Navigation-End ===== -->
</div>
    <!-- Page Content -->
    @yield('content')



</body>
<footer> <div class="text-center"><span class="footer" style="color: white"> Developed by Hasibul Kabir|
    {{env('APP_NAME')}} - App Version: v {{ env('APP_VERSION') }}</span></div>

    <!-- ===== jQuery ===== -->
    <script src="/plugins/components/jquery/dist/jquery.min.js"></script>
    <!-- ===== Bootstrap JavaScript ===== -->
    <script src="/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ===== Slimscroll JavaScript ===== -->
    <script src="/assets/js/jquery.slimscroll.js"></script>
    <!-- ===== Wave Effects JavaScript ===== -->
    <script src="/assets/js/waves.js"></script>
    <!-- ===== Menu Plugin JavaScript ===== -->
    <script src="/assets/js/sidebarmenu.js"></script>
    <!-- ===== Custom JavaScript ===== -->
    <script src="/assets/js/custom.js"></script>
    <!-- ===== Plugin JS ===== -->
    <!-- ===== Style Switcher JS ===== -->
    <script src="/plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
    @yield('footer-js')
</footer>
</html>

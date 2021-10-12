<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="/plugins/images/favicon.png">
    @yield('title')
    <!-- ===== Bootstrap CSS ===== -->
    <link href="/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <!-- ===== Animation CSS ===== -->
    <link href="/assets/css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="/assets/css/style.css" rel="stylesheet">
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

<body class="mini-sidebar">
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <!-- ===== Top-Navigation ===== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-bars"></i>
            </a>
            <div class="top-left-part">
                <a class="logo" href="/">
                    <b>
                        <img src="/plugins/images/logo.png" alt="home" />
                    </b>
                    <span>
                            <img src="/plugins/images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li>
                    <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
                </li>

            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="right-side-toggle">
                    <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="{{route('auth.logout')}}">
                        <i class="icon-close"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ===== Top-Navigation-End ===== -->
    <!-- ===== Left-Sidebar ===== -->
    <aside class="sidebar" role="navigation">
        <div class="scroll-sidebar">
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <div class="profile-image">

                        <img src="{{session('avatar_url')}}" alt="user-img" class="img-circle" style="object-fit: cover">

                    </div>
                    <p class="profile-text m-t-15 font-16"><a href="javascript:void(0);"> {{session('profile_name')}}</a></p>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul id="side-menu">
                    <li>
                        <a href="{{route('dashboard')}}" aria-expanded="false"><i class="icon-home fa-fw"></i> <span class="hide-menu"> Home </span></a>
                    </li>
                    @if((session('user_role')=='business'||session('user_role')=='front_desk')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-people fa-fw"></i> <span class="hide-menu"> Users</span></a>
                        <ul aria-expanded="false" class="collapse">

                            <li><a href="{{route('user.new')}}">Add Users</a></li>
                            <li><a href="{{route('user.view')}}">View Users</a></li>

                            @if(session('user_role')=='admin'||session('user_role')=='super_admin')
                                <li><a href="{{route('user.auth.list')}}">User Authorizations</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if((session('user_role')=='business')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-heart fa-fw"></i> <span class="hide-menu"> Clinics</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('clinic.new')}}">Add Clinics</a></li>
                            <li><a href="{{route('clinic.view')}}">View Clinics</a></li>
                            <li><a href="{{route('clinic.department')}}">Add Departments</a></li>
                            <li><a href="#">View Departments</a></li>
                            <li><a href="{{route('clinic.add.people')}}">Add People</a></li>
                            <li><a href="{{route('employee.list')}}">View People</a></li>
                            <li><a href="#">View Data</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-calender fa-fw"></i> <span class="hide-menu"> Appointments</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @if((session('user_role')=='business'||session('user_role')=='front_desk')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')
                            <li><a href="/">Book Appointment</a></li>
                            @endif
                            <li><a href="{{route('appointments')}}">View Appointments</a></li>
                        </ul>
                    </li>
                    @if(((session('user_role')=='business'||session('user_role')=='front_desk')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')||session('user_role')=='doctor')
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-clock fa-fw"></i> <span class="hide-menu"> Schedules</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @if(session('user_role')=='doctor')
                            <li><a href="{{route('routine.editor')}}">Create Routine</a></li>
                            @endif
                            <li><a href="#">View Routines</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(((session('user_role')=='business'||session('user_role')=='front_desk')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')||(session('user_role')=='doctor'||session('user_role')=='patient'))
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-pencil fa-fw"></i> <span class="hide-menu"> Prescriptions</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @if(session('user_role')=='doctor')
                            <li><a href="#">Create Prescription</a></li>
                            @endif
                            <li><a href="{{route('prescription.list')}}">View Prescriptions</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(session('user_role')=='admin'||session('user_role')=='super_admin')
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-location-pin fa-fw"></i> <span class="hide-menu"> Locations</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('location.country')}}">Add Country</a></li>
                                <li><a href="{{route('location.state')}}">Add State</a></li>
                                <li><a href="{{route('location.city')}}">Add City</a></li>
                                <li><a href="{{route('location.zone')}}">Add Zone</a></li>
                                <li><a href="{{route('location.area')}}">Add Area</a></li>
                                <li><a href="{{route('location.view')}}">View Locations</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(((session('user_role')=='business'||session('user_role')=='front_desk')
                            ||session('user_role')=='admin'||session('user_role')=='super_admin')||session('user_role')=='patient')
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-bag fa-fw"></i> <span class="hide-menu"> Bills</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @if(session('user_role')=='front_desk'||session('user_role')=='business')
                            <li><a href="{{route('billing.prescriptions')}}">Create Invoice</a></li>
                            @endif
                            <li><a href="{{route('billing.list')}}">View Bills</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-settings fa-fw"></i> <span class="hide-menu"> Settings</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('profile.settings')}}">Edit Profile</a></li>
                            <li><a href="{{route('password.changer')}}">Change Password</a></li>

                        </ul>
                    </li>


                    <li>
                        <a href="{{route('auth.logout')}}" aria-expanded="false"><i class="icon-close fa-fw"></i> <span class="hide-menu"> Logout </span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- ===== Left-Sidebar-End ===== -->
    <!-- Page Content -->
    @yield('content')
</div>


</body>
<footer> <span class="footer t-a-c"> Developed by Hasibul Kabir|
    {{env('APP_NAME')}} - App Version: v {{ env('APP_VERSION') }}</span>

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

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
<title>Complete User Info - GetDoc</title>
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
    <![endif]-->
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
                <a class="logo" href="index.html">
                    <b>
                        <img src="../plugins/images/logo.png" alt="home" />
                    </b>
                    <span>
                            <img src="../plugins/images/logo-text.png" alt="homepage" class="dark-logo" />
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

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Complete User Data</h3> </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div><br>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div><br>
            @endif
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"> Fill all the data</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{route('store.complete.registration')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <h3 class="box-title">Security Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" placeholder="Email" name="email" required> <span class="help-block"> Must be Unique </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Phone</label>
                                                <div class="col-md-9">
                                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required> <span class="help-block"> Better with Country Code </span> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <h3 class="box-title">Person Info</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">First Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="first_name" class="form-control" placeholder="Enter Firstname" required> <span class="help-block"> Without Initials </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Last Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="last_name" class="form-control" placeholder="Enter Lastname" required> <span class="help-block"> Last Name Only </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gender</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="gender" required>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="undefined">Undefined</option>
                                                    </select> <span class="help-block"> Select your gender. </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Date of Birth</label>
                                                <div class="col-md-9">
                                                    <input type="date" name="dob" class="form-control" placeholder="dd/mm/yyyy" required> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">

                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Profile Picture</label>
                                                <div class="col-md-9">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="file" name="avatar" value="profile-picture"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <h3 class="box-title">Address</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Country</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="country" id="country_selector" onchange="getStates()" required>
                                                        <option disabled selected value> -- Select Country -- </option>
                                                        @foreach(session('countries') as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">State/Division/Region</label>
                                                <div class="col-md-9">
                                                    <div>
                                                        <div id="state_list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">City</label>
                                                <div class="col-md-9">
                                                    <div>
                                                        <div id="city_list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Zone</label>
                                                <div class="col-md-9">
                                                    <div>
                                                        <div id="zone_list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Area</label>
                                                <div class="col-md-9">
                                                    <div>
                                                        <div id="area_list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">House No./Street</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="house" class="form-control" placeholder="Enter House/Street" required> <span class="help-block"> House/Street </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Post Code</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="post_code" class="form-control" placeholder="Enter Post Code" required> <span class="help-block"> Enter Your ZIP/Postal Code </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    @if(session('user_role')=='doctor')
                                        <h3 class="box-title">Doctor Details</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Designation</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Designation" name="designation" required> <span class="help-block"> Example: Cardiologist </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Specialities</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="specialities" class="form-control" placeholder="Input Your Specialities" required> <span class="help-block"> Mention Your Specialities </span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Education</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" placeholder="Give Education Details" name="education" required></textarea>
                                                    <span class="help-block"> Each line for each details. </span></div>
                                            </div>
                                        </div>
                                    @endif

                                    <!--/row-->
                                    <input type="hidden" name="status" value="active">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"> </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<footer> <span class="footer t-a-c"> Developed by Hasibul Kabir</span>
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
    <script>
        function getStates(url){
            let country_id=document.getElementById('country_selector').value;
            $.ajax({
                url: "/get-states/"+country_id,
            })
                .done(function(html) {
                    $("#state_list").empty();
                    $("#city_list").empty();
                    $("#zone_list").empty();
                    $("#area_list").empty();
                    $("#state_list").append(html);
                });
        }
    </script>
    <script>
        function getCities(url){
            let state_id=document.getElementById('state_options').value;
            $.ajax({
                url: "/get-cities/"+state_id,
            })
                .done(function(html) {
                    $("#city_list").empty();
                    $("#zone_list").empty();
                    $("#area_list").empty();
                    $("#city_list").append(html);
                });
        }
    </script>
    <script>
        function getZones(url){
            let city_id=document.getElementById('city_options').value;
            $.ajax({
                url: "/get-zones/"+city_id,
            })
                .done(function(html) {
                    $("#zone_list").empty();
                    $("#area_list").empty();
                    $("#zone_list").append(html);
                });
        }
    </script>
    <script>
        function getAreas(url){
            let zone_id=document.getElementById('zone_options').value;
            $.ajax({
                url: "/get-area-list/"+zone_id,
            })
                .done(function(html) {
                    $("#area_list").empty();
                    $("#area_list").append(html);
                });
        }
    </script>
</footer>
</html>




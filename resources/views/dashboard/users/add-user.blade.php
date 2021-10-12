@extends('layouts.dashboard')

@section('title')
    <title>Add New User - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Add New User</h3> </div>
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
                            <form action="{{route('store.user')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h3 class="box-title">Secured Information</h3>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Username</label>
                                            <div class="col-md-9">
                                                <input type="text" name="username" class="form-control" placeholder="Username" required> <span class="help-block"> Must be Unique </span> </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Password</label>
                                            <div class="col-md-9">
                                                <input type="password" name="password" class="form-control" placeholder="Enter Strong Password" required> <span class="help-block"> Minimum 6 Maximum 16 Characters </span> </div>
                                        </div>
                                    </div>
                                    <!--/span-->
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">User Type</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="role" id="user_type" data-placeholder="Choose User Type" onchange="enableDoctorField()" required>
                                                        <option disabled selected value> -- Select User Type -- </option>
                                                        @if(session('user_role')=='super_admin')
                                                            <option value="admin">Admin</option>
                                                        @endif
                                                        @if(session('user_role')=='super_admin'||session('user_role')=='admin')
                                                        <option value="business">Business</option>
                                                        @endif
                                                        <option value="patient">Patient</option>
                                                        <option value="doctor">Doctor</option>
                                                        <option value="front_desk">Front-Desk</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                    <!--/row-->
                                <!--doctor details-->
                                <div class="row">
                                <div id="doctor-details" class="form-body" style="display: none">
                                    <h3 class="box-title">Doctor Details</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Designation</label>
                                            <div class="col-md-9">
                                                <input type="text" id="designation" class="form-control" placeholder="Designation" name="designation"> <span class="help-block"> Example: Cardiologist </span> </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Specialities</label>
                                            <div class="col-md-9">
                                                <input type="text" id="specialities" name="specialities" class="form-control" placeholder="Input Your Specialities"> <span class="help-block"> Mention Your Specialities </span> </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Education</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" id="education" placeholder="Give Education Details" name="education"></textarea>
                                                <span class="help-block"> Each line for each details. </span></div>
                                        </div>
                                    </div>
                                </div>
                                </div>
<input type="hidden" name="status" value="active">
                                <div class="form-body">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('footer-js')
    <script>
        function enableDoctorField(){
            var user_type = document.getElementById('user_type').value;
            if (user_type==='doctor'){
                document.getElementById('doctor-details').style.display = 'block';
                document.getElementById('designation').required=true;
                document.getElementById('specialities').required=true;
                document.getElementById('education').required=true;
            }
            else {
                document.getElementById('doctor-details').style.display = 'none';
                document.getElementById('designation').required=false;
                document.getElementById('specialities').required=false;
                document.getElementById('education').required=false;
            }
        }
    </script>
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
@endsection

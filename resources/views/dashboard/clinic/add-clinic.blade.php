@extends('layouts.dashboard')

@section('title')
    <title>Add New Clinic - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Add New Clinic/Hospital</h3> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"> Fill all the data</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{route('store.clinic')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                    <h3 class="box-title">Basic Info</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Clinic/Hospital Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" class="form-control" placeholder="Enter Clinic Name" required> <span class="help-block"> Full Name </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required> <span class="help-block"> Business Email </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Phone</label>
                                                <div class="col-md-9">
                                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required> <span class="help-block"> Business Number </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Facilities</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="facilities" class="form-control" placeholder="Type the Facilities" required> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        @if(session('user_role')=='admin'||session('user_role')=='super_admin')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Owner's Username</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="owner" class="form-control" placeholder="Owner User Name" required> </div>
                                                </div>
                                            </div>
                                        @endif
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Logo</label>
                                                <div class="col-md-9">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="file" name="logo" value="logo"></label>
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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

@extends('layouts.dashboard')

@section('title')
    <title>Edit User - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Change Password - GetDoc</h3>
                    </div>

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div><br>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div><br>
    @endif




                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"> Fill all the data</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{route('store.user.edit')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data[0]->user_id}}">
                                    <input type="hidden" name="current_avatar_path" value="{{$data[0]->path}}">
                                    <div class="form-body">
                                        <h3 class="box-title">Secured Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{$data[0]->email}}" required> <span class="help-block"> Must be Unique </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Phone</label>
                                                <div class="col-md-9">
                                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{$data[0]->phone}}" required> <span class="help-block"> Better with Country Code </span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Edit Username?</label>

                                                    <input type="checkbox"  name="checkbox" value="checked"></div>


                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Username</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="username" class="disabled form-control" value="{{$data[0]->username}}" required readonly> <span class="help-block"> Must be Unique </span> </div>
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
                                                    <input type="text" name="first_name" class="form-control" placeholder="Enter Firstname" value="{{$data[0]->first_name}}" required> <span class="help-block"> Without Initials </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Last Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="last_name" class="form-control" placeholder="Enter Lastname" value="{{$data[0]->last_name}}" required> <span class="help-block"> Last Name Only </span> </div>
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
                                                        @if($data[0]->gender=='male')
                                                            <option value="male" selected>Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="undefined">Undefined</option>
                                                        @endif
                                                            @if($data[0]->gender=='female')
                                                                <option value="male">Male</option>
                                                                <option value="female" selected>Female</option>
                                                                <option value="undefined">Undefined</option>
                                                            @endif
                                                            @if($data[0]->gender=='undefined')
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                                <option value="undefined" selected>Undefined</option>
                                                            @endif
                                                    </select> <span class="help-block"> Select your gender. </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Date of Birth</label>
                                                <div class="col-md-9">
                                                    <input type="date" name="dob" class="form-control" placeholder="dd/mm/yyyy" value="{{date('Y-m-d',strtotime($data[0]->dob))}}" required> </div>
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
                                                    <select class="form-control" name="role" data-placeholder="Choose a Category" tabindex="1" required>
                                                        @if($data[0]->user_type=='business')
                                                            <option value="business" selected>Business</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="patient">Patient</option>
                                                            <option value="doctor">Doctor</option>
                                                        @endif
                                                            @if($data[0]->user_type=='admin')
                                                                <option value="business">Business</option>
                                                                <option value="admin" selected>Admin</option>
                                                                <option value="patient">Patient</option>
                                                                <option value="doctor">Doctor</option>
                                                            @endif
                                                            @if($data[0]->user_type=='patient')
                                                                <option value="business">Business</option>
                                                                <option value="admin">Admin</option>
                                                                <option value="patient" selected>Patient</option>
                                                                <option value="doctor">Doctor</option>
                                                            @endif
                                                            @if($data[0]->user_type=='doctor')
                                                                <option value="business">Business</option>
                                                                <option value="admin">Admin</option>
                                                                <option value="patient">Patient</option>
                                                                <option value="doctor" selected>Doctor</option>
                                                            @endif

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

                                                            <div class="fileupload btn btn-info waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Choose File</span>
                                                                <label class="radio-inline">
                                                            <input class="upload" type="file" name="avatar" value="profile-picture"></label>
                                                            </div>
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
                                                    <select class="form-control" name="country" required>
                                                        <option value="{{$data[0]->country_id}}">{{$data[0]->country}}</option>
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
                                                    <select class="form-control" name="state" required>
                                                        <option value="{{$data[0]->state_id}}">{{$data[0]->state}}</option>
                                                        @foreach(session('states') as $state)
                                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">City</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="city" required>
                                                        <option value="{{$data[0]->city_id}}">{{$data[0]->city}}</option>
                                                        @foreach(session('cities') as $city)
                                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Zone</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="zone" required>
                                                        <option value="{{$data[0]->zone_id}}">{{$data[0]->zone}}</option>
                                                        @foreach(session('zones') as $zone)
                                                            <option value="{{$zone->id}}">{{$zone->name}}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <select class="form-control" name="area" required>
                                                        <option value="{{$data[0]->area_id}}">{{$data[0]->area}}</option>
                                                        @foreach(session('areas') as $area)
                                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">House No./Street</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="house" class="form-control" placeholder="Enter House/Street" value="{{$data[0]->house}}" required> <span class="help-block"> House/Street </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Post Code</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="post_code" class="form-control" placeholder="Enter Post Code" value="{{$data[0]->post_code}}" required> <span class="help-block"> Enter Your ZIP/Postal Code </span>
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
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--/modal-->
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myLargeModalLabel">Confirm Action!</h4> </div>
                                            <div class="modal-body">
                                                <h4>Do you Want to Delete this User Profile?</h4>
                                                <p>It will permanently delete the user and related data. It is unrecoverable!</p>
                                            </div>
                                            <form method="post" action="/delete-user">
                                                @csrf
                                                <input type="hidden" name="user_type" value="{{$data[0]->user_type}}">
                                                <input type="hidden" name="id" value="{{$data[0]->user_id}}">
                                                <input type="hidden" name="username" value="{{$data[0]->username}}">
                                                <input type="hidden" name="current_avatar_path" value="{{$data[0]->path}}">
                                                <div class="modal-footer">
                                                    <p class="btn btn-default waves-effect" data-dismiss="modal">No</p>
                                                    <button type="submit" class="btn btn-danger waves-effect text-left">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!--/modal-->
                                <div class="pull-right">
                                    <button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')

@endsection

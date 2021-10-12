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
                        <h3 class="box-title">Change Password</h3>
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
                                <form action="{{route('store.password.change')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <h3 class="box-title">Secured Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Current Password</label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" name="current_password" required> <span class="help-block"> Current Password </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">New Password</label>
                                                <div class="col-md-9">
                                                    <input type="password" name="new_password" class="form-control"  required> <span class="help-block"> Make it Stronger </span> </div>
                                            </div>
                                        </div>
                                    <!--/row-->
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

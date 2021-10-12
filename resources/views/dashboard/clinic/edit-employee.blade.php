@extends('layouts.dashboard')

@section('title')
    <title>Edit Employee - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Edit Employee Data</h3>
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
                                <form action="{{route('store.edit.employee')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data[0]->employee_id}}">
                                    <div class="form-body">
                                        <h3 class="box-title">Employee Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <p>Name: {{$data[0]->first_name}} {{$data[0]->last_name}}</p>
                                        <p>Clinic: {{$data[0]->name}}</p>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Employment Status</label>
                                                <div class="col-md-9">
                                                    <select name="employment_status" class="form-control">
                                                        @if($data[0]->employement_status='active')
                                                            <option value="active" selected>Active</option>
                                                            <option value="inactive">Inactive</option>
                                                            <option value="left">Release</option>
                                                            <option value="suspended">Suspend</option>
                                                        @elseif($data[0]->employement_status='inactive')
                                                            <option value="active">Active</option>
                                                            <option value="inactive" selected>Inactive</option>
                                                            <option value="left">Release</option>
                                                            <option value="suspended">Suspend</option>
                                                        @elseif($data[0]->employement_status='suspended')
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                            <option value="left">Release</option>
                                                            <option value="suspended" selected>Suspend</option>
                                                        @elseif($data[0]->employement_status='left')
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                            <option value="left" selected>Release</option>
                                                            <option value="suspended">Suspend</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Post Name</label>
                                                <div class="col-md-9">
                                                    <input type="tel" name="post_name" class="form-control" value="{{$data[0]->post_name}}" required> <span class="help-block"> Better with Country Code </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
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

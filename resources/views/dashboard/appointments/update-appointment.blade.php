@extends('layouts.dashboard')

@section('title')
    <title>Edit Appointment - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Edit Appointment Data</h3>
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
                                <form action="{{route('store.appointment.update')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input readonly required type="hidden" name="id" value="{{$data[0]->id}}">
                                    <div class="form-body">
                                        <h3 class="box-title">Appointment Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select required class="form-control" name="status">
                                                    <option selected value disabled>-- Select Action --</option>
                                                    <option value="cancelled">Cancel</option>
                                                    @if(session('user_role')=='super_admin'||(session('user_role')=='business'||session('user_role')=='admin'))
                                                        <option value="pending">Pending</option>
                                                        <option value="expired">Expire</option>
                                                        <option value="completed">Complete</option>
                                                    @endif
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Note</label>
                                                <div class="col-md-9">
                                                    <textarea rows="5" class="form-control" name="note">{{$data[0]->note}}</textarea>
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

@extends('layouts.dashboard')

@section('title')
    <title>Prescription List - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">All Prescriptions</h3>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div><br>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div><br>
                        @endif
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                                @php
                                    $serial = 1;
                                    $i=0;
                                @endphp
                                @if(session('user_role')=='doctor')
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prescriptions as $prescription)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$prescription->first_name}} {{$prescription->last_name}}</td>
                                        <td>{{date('h:i A - D d M Y',strtotime($prescription->created_at))}}</td>
                                        @if($prescription->status=='pending')
                                            <td><span class="label label-danger">Pending</span></td>
                                        @elseif($prescription->status=='invoiced')
                                            <td><span class="label label-info">Invoiced</span></td>
                                        @else
                                            <td><span class="label label-success">Approved</span></td>
                                        @endif
                                        <td><a href="/view-prescription/{{$prescription->id}}" target="_blank"><button class="button btn-primary">View</button></a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                                @if(session('user_role')=='patient')
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Doctor Name</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prescriptions as $prescription)
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$doctors[$i]['first_name']}} {{$doctors[$i++]['last_name']}}</td>
                                            <td>{{date('h:i A - D d M Y',strtotime($prescription->created_at))}}</td>
                                            @if($prescription->status=='pending')
                                                <td><span class="label label-danger">Pending</span></td>
                                                <td><a href="#"><button class="button btn-warning" disabled>View</button></a></td>
                                            @elseif($prescription->status=='invoiced')
                                                <td><span class="label label-info">Invoiced</span></td>
                                                <td><a href="#"><button class="button btn-warning" disabled>View</button></a></td>
                                            @else
                                                <td><span class="label label-success">Approved</span></td>
                                                <td><a href="/view-prescription/{{$prescription->id}}" target="_blank"><button class="button btn-primary">View</button></a></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
@endsection

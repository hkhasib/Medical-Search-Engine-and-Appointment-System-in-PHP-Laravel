@extends('layouts.dashboard')

@section('title')
    <title>Create Prescription - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Appointments</h3>
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
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Time</th>
                                        <th>Payment Status</th>
                                        <th>Billing Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($prescriptions as $prescription)
                                        <tbody>
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$prescription->first_name}} {{$prescription->last_name}}</td>
                                            <td>{{$doctors[$i]['first_name']}} {{$doctors[$i++]['last_name']}}</td>
                                            <td>{{date('h:i A - D d M Y',strtotime($prescription->created_at))}}</td>
                                            @if($prescription->status=='pending')
                                                <td><span class="label label-danger">Pending</span></td>
                                                <td><a href="/create-bill/{{$prescription->id}}/{{$prescription->appointment_id}}/{{$prescription->user_id}}/{{$prescription->doctor_id}}" target="_blank"><button class="button btn-primary">Create Invoice</button></a></td>
                                            @elseif($prescription->status=='invoiced')
                                                <td><span class="label label-info">Invoiced</span></td>
                                                <td><a href="#"><button class="button btn-info" disabled>Create Invoice</button></a></td>
                                            @else
                                                <td><span class="label label-success">Approved</span></td>
                                                <td><a href="#"><button class="button btn-info" disabled>Create Invoice</button></a></td>
                                            @endif



                                        </tr>
                                    @endforeach
                                        </tbody>
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

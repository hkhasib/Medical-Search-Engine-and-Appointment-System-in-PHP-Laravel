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
                                    <th>Doctor Name</th>
                                    <th>Time</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($bills as $bill)
                                    <tbody>
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$bill->first_name}} {{$bill->last_name}}</td>
                                        <td>{{date('h:i A - D d M Y',strtotime($bill->created_at))}}</td>
                                        @if($bill->payment_status=='pending')
                                            <td><span class="label label-danger">Pending</span></td>
                                        @elseif($bill->status=='invoiced')
                                            <td><span class="label label-info">Invoiced</span></td>
                                        @else
                                            <td><span class="label label-success">Paid</span></td>
                                        @endif
                                        <td><a href="/view-invoice/{{$bill->id}}" target="_blank"><button class="button btn-primary">View Invoice</button></a></td>

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

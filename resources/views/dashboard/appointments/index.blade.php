@extends('layouts.dashboard')

@section('title')
    <title>Appointments - GetDoc</title>
    <link href="../plugins/components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('header-js')
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <div>
                            <form method="post" action="{{route('appointments.custom')}}">
                                @csrf
                                <div class="form-group">
                                    <select name="data_range" required class="form-control">
                                        <option selected disabled value>--Select Data Range--</option>
                                        <option value="today">Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="this_month">This Month</option>
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Get Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                                @if(session('user_role')=='doctor')
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Appointment Date</th>
                                        <th>Clinic</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    @foreach($patient_list as $patient)
                                        <tbody>
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$patient->patient_first_name}} {{$patient->patient_last_name}}</td>
                                            <td>{{date('h:i A - D d M Y',strtotime($patient->appointment_time))}}</td>
                                            <td>{{$patient->clinic_name}}</td>
                                            <td>{{$patient->house}}, {{$patient->area}}, {{$patient->zone}}, {{$patient->city}}, {{$patient->state}}, {{$patient->country}}, {{$patient->post_code}}</td>
                                            @if($patient->status=='pending')
                                                <td>
                                                <span class="label label-info">Upcoming</span>
                                                </td>
                                                <td><a href="http://getdoc.com/create-prescription?appointment_id={{$patient->appointment_id}}" target="_blank"><button class="btn btn-primary" >Create Prescription</button></a></td>
                                            @endif
                                            @if($patient->status=='completed')
                                                <td>
                                                    <span class="label label-success">Done</span>
                                                </td>

                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Create Prescription</button></a></td>
                                            @endif
                                            @if($patient->status=='expired')
                                                <td>
                                                    <span class="label label-danger">Expired</span>
                                                </td>

                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Create Prescription</button></a></td>
                                            @endif
                                            @if($patient->status=='cancelled')
                                                <td>
                                                    <span class="label label-danger">Cancelled</span>
                                                </td>

                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Create Prescription</button></a></td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    @endif

                                @if(session('user_role')=='patient'||session('user_role')=='front_desk')
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Doctor Name</th>
                                        <th>Appointment Date</th>
                                        <th>Clinic</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    @foreach($patient_list as $patient)
                                        <tbody>
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$doctor_list[$i]['doctor_first_name']}} {{$doctor_list[$i++]['doctor_last_name']}}</td>
                                            <td>{{date('h:i A - D d M Y',strtotime($patient->appointment_time))}}</td>
                                            <td>{{$patient->clinic_name}}</td>
                                            <td>{{$patient->house}}, {{$patient->area}}, {{$patient->zone}}, {{$patient->city}}, {{$patient->state}}, {{$patient->country}}, {{$patient->post_code}}</td>
                                            @if($patient->status=='pending')
                                                <td>
                                                    <span class="label label-info">Upcoming</span>
                                                </td>
                                                <td><a href="http://getdoc.com/update-appointment/{{$patient->appointment_id}}" target="_blank"><button class="btn btn-primary" >Update Appointment</button></a></td>
                                            @endif
                                            @if($patient->status=='completed')
                                                <td>
                                                    <span class="label label-success">Done</span>
                                                </td>

                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Update Appointment</button></a></td>
                                            @endif
                                            @if($patient->status=='expired')
                                                <td>
                                                    <span class="label label-danger">Cancelled/Expired</span>
                                                </td>
                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Update Appointment</button></a></td>
                                            @endif
                                            @if($patient->status=='cancelled')
                                                <td>
                                                    <span class="label label-danger">Cancelled</span>
                                                </td>
                                                <td><a href="#" target="_blank"><button class="btn btn-info" disabled >Update Appointment</button></a></td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endif

                                @if((session('user_role')=='admin'||session('user_role')=='business')||session('user_role')=='super_admin')
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Appointment Date</th>
                                        <th>Clinic</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($patient_list as $patient)
                                        <tr>
                                            <td>{{$serial++}}</td>
                                            <td>{{$patient->patient_first_name}} {{$patient->patient_last_name}}</td>
                                            <td>{{$doctor_list[$i]['doctor_first_name']}} {{$doctor_list[$i++]['doctor_last_name']}}</td>
                                            <td>{{date('h:i A - D d M Y',strtotime($patient->appointment_time))}}</td>
                                            <td>{{$patient->clinic_name}}</td>
                                            <td>{{$patient->house}}, {{$patient->area}}, {{$patient->zone}}, {{$patient->city}}, {{$patient->state}}, {{$patient->country}}, {{$patient->post_code}}</td>
                                            @if($patient->status=='pending')
                                                <td>
                                                    <span class="label label-info">Upcoming</span>
                                                </td>
                                            @endif
                                            @if($patient->status=='completed')
                                                <td>
                                                    <span class="label label-success">Done</span>
                                                </td>
                                            @endif
                                            @if($patient->status=='expired')
                                                <td>
                                                    <span class="label label-danger">Expired</span>
                                                </td>
                                            @endif
                                            @if($patient->status=='cancelled')
                                                <td>
                                                    <span class="label label-danger">Cancelled</span>
                                                </td>
                                            @endif
                                            <td><a href="http://getdoc.com/update-appointment/{{$patient->appointment_id}}" target="_blank"><button class="btn btn-primary" >Update</button></a></td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('footer-js')
            <script src="../plugins/components/datatables/jquery.dataTables.min.js"></script>
            <!-- start - This is for export functionality only -->
            <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
            <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
            <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
            <!-- end - This is for export functionality only -->

@endsection

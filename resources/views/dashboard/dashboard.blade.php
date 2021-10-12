@extends('layouts.dashboard')

@section('title')
    <title>Dashboard - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                @if((session('user_role')=='admin'||session('user_role')=='super_admin')||session('user_role')=='business')
                <div class="row colorbox-group-widget">
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count">{{$data['appointment_count']}} <span class="pull-right"><i class="mdi mdi-calendar-clock"></i></span></h3>
                                    <p class="info-text font-16">Appointments</p>
                                    <p class="info-ot font-15">Pending<span class="label label-rounded">{{$data['upcoming_appointments']}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-success">
                                <div class="media-body">
                                    <h3 class="info-count">{{$data['patient_count']}} <span class="pull-right"><i class="mdi mdi-nature-people"></i></span></h3>
                                    <p class="info-text font-16">Patients</p>
                                    <p class="info-ot font-15">Newly Registered<span class="label label-rounded">{{$data['new_patients']}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-danger">
                                <div class="media-body">
                                    <h3 class="info-count">{{$data['doctor_count']}} <span class="pull-right"><i class="mdi mdi-medical-bag"></i></span></h3>
                                    <p class="info-text font-16">Doctors</p>
                                    <p class="info-ot font-15">New Doctors<span class="label label-rounded">{{$data['new_doctors']}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-info">
                                <div class="media-body">
                                    <h3 class="info-count">{{$data['clinic_count']}} <span class="pull-right"><i class="mdi mdi-hospital"></i></span></h3>
                                    <p class="info-text font-16">Total Clinics</p>
                                    <p class="info-ot font-15">Newly Added<span class="label label-rounded">{{$data['new_clinics']}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                    @if((session('user_role')=='front_desk'))
                        <div class="row colorbox-group-widget">
                            <div class="col-md-3 col-sm-6 info-color-box">
                                <div class="white-box">
                                    <div class="media bg-primary">
                                        <div class="media-body">
                                            <h3 class="info-count">{{$data['appointment_count']}} <span class="pull-right"><i class="mdi mdi-calendar-clock"></i></span></h3>
                                            <p class="info-text font-16">Appointments</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 info-color-box">
                                <div class="white-box">
                                    <div class="media bg-success">
                                        <div class="media-body">
                                            <h3 class="info-count">{{$data['patient_count']}} <span class="pull-right"><i class="mdi mdi-nature-people"></i></span></h3>
                                            <p class="info-text font-16">Patients</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 info-color-box">
                                <div class="white-box">
                                    <div class="media bg-danger">
                                        <div class="media-body">
                                            <h3 class="info-count">{{$data['doctor_count']}} <span class="pull-right"><i class="mdi mdi-medical-bag"></i></span></h3>
                                            <p class="info-text font-16">Doctors</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 info-color-box">
                                <div class="white-box">
                                    <div class="media bg-info">
                                        <div class="media-body">
                                            <h3 class="info-count">{{$data['clinic_count']}} <span class="pull-right"><i class="mdi mdi-hospital"></i></span></h3>
                                            <p class="info-text font-16">Total Clinics</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(session('user_role')=='doctor'||session('user_role')=='patient')
                        <div class="row colorbox-group-widget">
                            <div class="col-md-3 col-sm-6 info-color-box">
                                <div class="white-box">
                                    @if(isset($next_appointment))
                                    <div class="media bg-primary">
                                        <div class="media-body">
                                            <h3 class="info-count">{{$next_appointment['first_name']}} {{$next_appointment['last_name']}}<span class="pull-right"><i class="mdi mdi-calendar-clock"></i></span></h3>
                                            <p class="info-text font-16">Next Appointment</p>
                                            <p class="info-ot font-15">Time<span class="label label-rounded">{{date('h:i A D d M Y',strtotime($next_appointment['appointment_time']))}}</span></p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @php
                        $serial = 1;
                        $i=0;
                    @endphp
                <div class="row">
                    <div class="col-sm-12">
                    <div class="white-box">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Appointment Date</th>
                                <th>Clinic</th>
                                <th>Address</th>
                                <th>Status</th>
                                @if(session('user_role')=='doctor')
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>

                                <tbody>
                                @foreach($patient_list as $patient)
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
                                    @if(session('user_role')=='doctor')
                                        <td><a href="http://getdoc.com/create-prescription?appointment_id={{$patient->appointment_id}}" target="_blank"><button class="btn btn-primary" >Create Prescription</button></a></td>
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
    <script>
        $(function() {
            $('#myTable').DataTable();

            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
@endsection

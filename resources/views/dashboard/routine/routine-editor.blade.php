@extends('layouts.dashboard')

@section('title')
    <title>Create Routine - GetDoc</title>
    <link href="../plugins/components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('header-js')
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Create Routine</h3> </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div><br>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div><br>
            @endif
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"> Fill all the data</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{route('store.routine')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <h3 class="box-title">Routine Time</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">From</label>
                                                <div class="col-md-9">
                                                    <div class="input-group clockpicker"></div>
                                                    <input type="time" class="form-control" placeholder="From time" name="from" required> <span class="help-block"> Choose when you start your work here </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">To</label>
                                                <div class="col-md-9">
                                                    <input type="time" name="to" class="form-control" placeholder="Enter To Time" required> <span class="help-block"> Choose When You End Your Duty Here </span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Time Interval</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="interval" class="form-control" placeholder="Input Value of Minutes in Number" required> <span class="help-block"> Average time in Minutes you spend for each patients. </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Select Day</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="day" required>
                                                        <option disabled selected value> -- Select Day -- </option>
                                                        <option value="saturday">Saturday</option>
                                                        <option value="sunday">Sunday</option>
                                                        <option value="monday">Monday</option>
                                                        <option value="tuesday">Tuesday</option>
                                                        <option value="wednesday">Wednesday</option>
                                                        <option value="thursday">Thursday</option>
                                                        <option value="friday">Friday</option>
                                                    </select> <span class="help-block"> Select Your Work Day </span> </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="user_id" value="{{session('user_id')}}">
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <h3 class="box-title">Work Place</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Clinic</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="clinic_id" id="clinic_selector" required>
                                                        <option disabled selected value> -- Select Clinic -- </option>
                                                        @foreach(session('clinics') as $clinic)
                                                            <option value="{{$clinic->id}}">{{$clinic->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-body">
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
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Your Routine and Schedules</h3>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Day</th>
                                <th>Place</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $serial = 1;
                            @endphp
                            @foreach(session('routines') as $data)
                                <tr>
                                    <td>{{$serial++}}</td>
                                    <td>{{date('h:i A',strtotime($data->from_time))}}</td>
                                    <td>{{date('h:i A',strtotime($data->to_time))}}</td>
                                    <td>{{ucfirst($data->day)}}</td>
                                    <td>{{$data->name}}</td>
                                </tr>
                            @endforeach
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

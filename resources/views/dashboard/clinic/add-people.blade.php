@extends('layouts.dashboard')

@section('title')
    <title>Departments - GetDoc</title>
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
                        <h3 class="box-title">Add People</h3></div>
                    <div class="col-sm-12 col-xs-12">
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div><br>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div><br>
                        @endif
                        <form method="post" action="{{route('store.employee')}}">
                            @csrf
                            <div class="form-group">
                                <div>
                                    <select class="form-control" name="clinic_id" id="clinic_selector" onchange="getDepartments()" required>
                                        <option disabled selected value> -- Select Clinic -- </option>
                                        @foreach(session('clinics') as $clinic)
                                            <option value="{{$clinic->id}}">{{$clinic->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <div id="department_list"></div>
                                </div>
                                <select class="form-control" name="post_name" id="user_type" data-placeholder="Choose Employee Type" required>
                                    <option disabled selected value> -- Select Employee Type -- </option>
                                    <option value="doctor">Doctor</option>
                                    <option value="front_desk">Front-Desk</option>
                                </select>
                                <input type="hidden" name="employment_status" value="active">
                                <div class="input-group m-t-10">
                                    <input type="text" name="username" class="form-control" placeholder="Username"> <span class="input-group-btn">
                      <button type="submit" class="btn waves-effect waves-light btn-primary">Add Now</button>
                      </span> </div>

                            </div>
                            <!-- form-group -->
                        </form>
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
                function getDepartments(url){
                    let clinic_id=document.getElementById('clinic_selector').value;
                    $.ajax({
                        url: "/get-department-list/"+clinic_id,
                    })
                        .done(function(html) {
                            $("#department_list").empty();
                            $("#department_list").append(html);
                        });
                }
            </script>


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

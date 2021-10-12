@extends('layouts.dashboard')

@section('title')
    <title>Areas - GetDoc</title>
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
                        <h3 class="box-title">Add New Areas</h3></div>
                    <div class="col-sm-12 col-xs-12">
                        <form method="post" action="{{route('store.location.area')}}">
                            @csrf
                            <div class="form-group">
                                <div class="form-group">
                                    <div>
                                        <select class="form-control" name="country" id="country_selector" required onchange="getStates()">
                                            <option disabled selected value> -- Select Country -- </option>
                                            @foreach(session('countries') as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div>
                                    <div id="state_list"></div>
                                </div>
                                <div>
                                    <div id="city_list"></div>
                                </div>
                                <div>
                                    <div id="zone_list"></div>
                                </div>
                                <div class="input-group m-t-10">
                                    <input type="text" name="area" class="form-control" placeholder="State Name"> <span class="input-group-btn">
                      <button type="submit" class="btn waves-effect waves-light btn-primary">Add Now</button>
                      </span> </div>

                            </div>
                            <!-- form-group -->
                        </form>
                    </div>

                </div>
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Operational States List</h3>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Area</th>
                                    <th>Zone</th>
                                    <th>City</th>
                                    <th>State/Region</th>
                                    <th>Country</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $serial = 1;
                                @endphp
                                @foreach($data_list as $data)
                                    <tr>
                                        <td>{{$serial++}}</td>
                                        <td>{{$data->area_name}}</td>
                                        <td>{{$data->zone_name}}</td>
                                        <td>{{$data->city_name}}</td>
                                        <td>{{$data->state_name}}</td>
                                        <td>{{$data->country_name}}</td>
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
                function getStates(url){
                    let country_id=document.getElementById('country_selector').value;
                    $.ajax({
                        url: "/get-states/"+country_id,
                    })
                        .done(function(html) {
                            $("#state_list").empty();
                            $("#city_list").empty();
                            $("#zone_list").empty();
                            $("#state_list").append(html);
                        });
                }
            </script>
            <script>
                function getCities(url){
                    let state_id=document.getElementById('state_options').value;
                    $.ajax({
                        url: "/get-cities/"+state_id,
                    })
                        .done(function(html) {
                            $("#city_list").empty();
                            $("#city_list").append(html);
                        });
                }
            </script>
            <script>
                function getZones(url){
                    let city_id=document.getElementById('city_options').value;
                    $.ajax({
                        url: "/get-zones/"+city_id,
                    })
                        .done(function(html) {
                            $("#zone_list").empty();
                            $("#zone_list").append(html);
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

@extends('layouts.dashboard')

@section('title')
    <title>Prescription - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box printableArea">
                        <h3><b>Prescription</b> <span class="pull-right">#{{$prescription->prescription_id}}</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
                                        <h3> &nbsp;<b class="text-danger">{{$prescription->doctor_first_name}} {{$prescription->doctor_last_name}}</b></h3>
                                        <h4> &nbsp;<b>{{$prescription->clinic_name}}</b></h4>
                                        <p class="text-muted m-l-5">{{$prescription->department_name}}
                                            <br/> {{$prescription->house}},
                                            <br/> {{$prescription->area}},
                                            <br/> {{$prescription->zone}},
                                            <br>  {{$prescription->city}},{{$prescription->state}},
                                            <br/> {{$prescription->country}}-{{$prescription->post_code}}.</p>
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        <h3>Patient,</h3>
                                        <h4 class="font-bold">{{$user->first_name}} {{$user->last_name}}</h4>
                                        <p class="m-t-30"><b>Date :</b> <i class="fa fa-calendar"></i> {{date('d M Y',strtotime($prescription->date))}}</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <p>{{$prescription->description}}</p>
                                </div>
                            </div>
                                    <div class="text-right">
                                        <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
            @section('footer-js')
                <script src="/assets/js/jquery.PrintArea.js" type="text/JavaScript"></script>
                <script>
                    $(function() {
                        $("#print").on("click", function() {
                            var mode = 'iframe';
                            var close = mode == "popup";
                            var options = {
                                mode: mode,
                                popClose: close
                            };
                            $("div.printableArea").printArea(options);
                        });
                    });
                </script>
@endsection

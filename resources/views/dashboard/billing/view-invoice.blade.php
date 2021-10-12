@extends('layouts.dashboard')

@section('title')
    <title>Invoice - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box printableArea">
                        <h3><b>INVOICE</b> <span class="pull-right">#{{$invoice->id}}</span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
                                        <h3> &nbsp;<b class="text-danger">{{$invoice->clinic_name}}</b></h3>
                                        <p class="text-muted m-l-5">{{$invoice->house}}
                                            <br/> {{$invoice->area}},
                                            <br/> {{$invoice->zone}},
                                            <br>  {{$invoice->city}},{{$invoice->state}},
                                            <br/> {{$invoice->country}}-{{$invoice->post_code}}.</p>
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        <h3>To,</h3>
                                        <h4 class="font-bold">{{$user->first_name}} {{$user->last_name}}</h4>
                                        <p class="text-muted m-l-30">{{$user->house}},
                                            <br/> {{$user->area}},{{$user->zone}}
                                            <br/> {{$user->city}},{{$user->state}},
                                            <br/> {{$user->country}}</p>
                                        <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{date('d M Y',strtotime($invoice->date))}}</p>
                                        <p><b>Due Date :</b> <i class="fa fa-calendar"></i> {{date('d M Y',strtotime($invoice->date))}}</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Details</th>
                                            <th class="text-right">Price</th>
                                        </tr>
                                        </thead>
                                        @php
                                        $sl=1;
                                        @endphp
                                        <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Doctor Fee</td>
                                            <td class="text-right"> {{$invoice->doctor_fee}} </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Others</td>
                                            <td class="text-right"> {{$invoice->other_fee}} </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right m-t-30 text-right">
                                    <p>Sub - Total amount: {{$invoice->total}}</p>
                                    <p>Discount: {{$invoice->discount}}% </p>
                                    <hr>
                                    <h3><b>Total :</b> {{$invoice->final_total}}</h3> </div>
                                <div class="clearfix"></div>
                                <hr>
                                <form method="post" action="{{route('complete.payment')}}">
                                <div class="text-right">

                                    @if(session('user_role')!='patient'&&$invoice->payment_status=='pending')
                                            @csrf
                                            <input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}" readonly required>
                                            <button class="btn btn-danger" type="submit"> Complete Payment </button>
                                    @endif

                                    <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                </div>
                                </form>
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

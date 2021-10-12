@extends('layouts.dashboard')

@section('title')
    <title>Add New User - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Create New Bill</h3> </div>
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
                                <form action="{{route('store.invoice')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="form-body">
                                                <h3 class="box-title">Prescription Info</h3>
                                                <hr class="m-t-0 m-b-40">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Patient</label>
                                                        <div class="col-md-9">
                                                            <span class="form-control">{{$patient->first_name}} {{$patient->last_name}}</span>
                                                            <input type="hidden" name="user_id" value="{{$user_id}}" readonly required>
                                                            <input type="hidden" name="prescription_id" value="{{$prescription_id}}" readonly required>
                                                            <input type="hidden" name="appointment_id" value="{{$appointment_id}}" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Doctor</label>
                                                        <div class="col-md-9">
                                                            <span class="form-control">{{$doctor->first_name}} {{$doctor->last_name}}</span>
                                                            <input type="hidden" name="doctor_id" value="{{$doctor_id}}" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Details</label>
                                                        <div class="col-md-9">
                                                            <textarea rows="10" readonly required class="form-control">{{$prescription->description}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <h3 class="box-title">Billing Details</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Doctor Fee</label>
                                                <div class="col-md-9">
                                                    <input name="doctor_fee" type="number" class="form-control" placeholder="Amount" id="doctor_fee" required onkeyup="calculateTotal()"> <span class="help-block"> Number Only in BDT </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Other Fees</label>
                                                <div class="col-md-9">
                                                    <input name="other_fee" type="number" value="0" id="other_fee" class="form-control" placeholder="Type Amount" required onkeyup="calculateTotal()"> <span class="help-block"> Number Only in BDT  </span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Discount</label>
                                                <div class="col-md-9">
                                                    <input name="discount" type="number" id="discount" value="0" class="form-control" placeholder="Discount Amount in %" required onkeyup="calculateTotal()"> <span class="help-block"> Discount in Percentage Only </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Total</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="total" id="total" class="form-control" value="" placeholder="Total Amount" required readonly> <span class="help-block"> Total Amount After Calculation </span> </div>
                                            </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Final Total</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="final_total" id="final_total" class="form-control" value="" placeholder="Total Amount" required readonly> <span class="help-block"> Total After Final Calculation with Discount </span> </div>
                                                </div>
                                            </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Remarks</label>
                                                <div class="col-md-9">
                                                    <textarea rows="10" class="form-control" name="description" required></textarea><span class="help-block"> Mention any specific billing details </span> </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    </div>
                                    <div class="form-body">
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button type="submit" id="submit_btn" class="btn btn-success">Submit</button>
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
        </div>
    </div>
@endsection
@section('footer-js')
<script>
    function calculateTotal(){
        let doctor_fee=+document.getElementById('doctor_fee').value;
        let other_fee=+document.getElementById('other_fee').value;
        let discount=+document.getElementById('discount').value;
        document.getElementById('total').value = doctor_fee+other_fee;
        if (discount>100){
            document.getElementById('discount').value = 0;
            alert('Discount limit exceeds');
            document.getElementById('final_total').value = "";
        }
        else {
            let final_discount = (discount/100)*(doctor_fee+other_fee)
            let final_total = (doctor_fee+other_fee)-final_discount;
            document.getElementById('final_total').value = final_total;
        }

    }
</script>
@endsection

@extends('layouts.dashboard')

@section('title')
    <title>Create Prescription - GetDoc</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Create Prescription</h3> </div>
                </div>
                <div>
                   <form method="post" action="{{route('store.prescription')}}">
                       @csrf
                       <textarea required name="description" rows="20" class="form-control" placeholder="Write your prescription....." style="font-size: 20px"></textarea>
                       <input type="hidden" name="appointment_id" value="{{$appointment_id}}" required readonly>
                       <div class="text-center">

                           <input type="submit" value="Submit" class="btn btn-danger">
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
@endsection

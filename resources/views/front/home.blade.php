@extends('layouts.front')

@section('title')
    <title>GetDoc - Find Doctor and Clinic Easily</title>
@endsection
@section('content')
    <div class="container" style="margin-top: 8%;">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div id="logo" class="text-center">
                    <img src="/assets/sq-logo.png">
                    <h1>GetDoc</h1><p>Find Nearby Doctors and Clinics</p>
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div><br>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div><br>
                    @endif
                </div>
                <form role="form" method="get" action="{{route('search.action')}}">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="text" name="keyword" placeholder="Search..." required/>
                            <span class="input-group-btn">
<button class="btn btn-primary" type="submit">
<i class="glyphicon glyphicon-search" aria-hidden="true"></i> Search
</button>
</span>

                        </div>
                        <hr>
                        <div class="text-center"><label>Want location based result?</label> <input type="checkbox"></div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

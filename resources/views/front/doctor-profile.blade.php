@extends('layouts.front')

@section('title')
    <title>Dr. {{$doctor->first_name}} {{$doctor->last_name}} - GetDoc</title>
@endsection
@section('content')
    <main>

        <div class="container margin_60">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <nav id="secondary_nav">
                        <div class="container">

                                <span style="color: white">Doctor info</span>

                        </div>
                    </nav>
                    <div id="section_1">
                        <div class="box_general">
                            <div class="profile">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4">
                                        <figure>
                                            <img src="{{$doctor->link}}" style="object-fit: cover" width="230px" height="200px">
                                        </figure>
                                    </div>
                                    <div class="col-lg-7 col-md-8">
                                        <small>{{$doctor->designation}}</small>
                                        <h1>Dr. {{$doctor->first_name}} {{$doctor->last_name}}</h1>
                                                <h6>Email: </h6><a><strong>{{$doctor->email}}</strong></a>
                                                <h6>Phone:</h6> <a href="tel://{{$doctor->phone}}">{{$doctor->phone}}</a>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- /profile -->
                            <div class="indent_title_in">
                                <i class="pe-7s-user"></i>
                                <h3>Work Places</h3>
                            </div>
                            <div class="wrapper_indent">
                                @foreach($place as $place)
                                    <p style="font-weight: bold">{{$place->clinic}} </p>
                                    <p>Address: {{$place->house}}, {{$place->area}}, {{$place->zone}}, {{$place->city}}, {{$place->country}}</p><br>
                                @endforeach

                            </div>
<hr>
                            <div class="indent_title_in">
                                <i class="pe-7s-user"></i>
                                <h3>Specialities</h3>
                            </div>
                            <div class="wrapper_indent">
                                <p>{{$doctor->specialities}}</p>
                            </div>

                            <hr>

                            <div>
                                <h3>Education</h3>
                            </div>
                            <div class="wrapper_indent">
                                <p>{{$doctor->education}}</p>
                            </div>


                            <hr>

                            <div>
                                <h3>Availability</h3>
                            </div>
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Day</th>
                                            <th>From</th>
                                            <th>To</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $i=0;
                                            $sl=1;
                                        @endphp
                                        @foreach($from_times as $from)


                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{ucfirst($days[$i]['day'])}}</td>
                                            <td>{{$from['from_time']}}</td>
                                            <td>{{$to_times[$i]['to_time']}}</td>
                                            <span style="display: none">{{$i++}}</span>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--  /wrapper_indent -->
                        </div>
                        <!-- /section_1 -->
                    </div>
                </div>
                <!-- /col -->
                <aside class="col-xl-4 col-lg-4" id="sidebar">
                    <div class="box_general booking">
                        <div class="title">
                            <h3>Book a Visit</h3>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div><br>
                            <script>swal("Success!", "{{ session('success') }}", "success");</script>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div><br>
                            <script>swal("Error!", "{{ session('error') }}", "error");</script>
                        @endif
                        <form method="post" action="{{route('store.appointment')}}" id="booking">
                            @csrf
                            <!-- /row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <select style="text-align-last:center;" class="form-control" name="clinic_id" id="clinic_selector" onchange="getRoutines()">
                                            <option disabled selected value>-- Select Clinic --</option>
                                            @foreach(session('clinics') as $p)
                                                <option value="{{$p->clinic_id}}">{{$p->clinic}}</option>
                                            @endforeach
                                            <input type="hidden" value="{{$doctor_id}}" name="doctor_id" id="doctor_id" readonly>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">

                                        <div id="routines_by_clinic">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="date" name="appointment_date" id="routine_date" onchange="getTimes()" disabled required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div id="time_options">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea name="note" rows="5" id="booking_message" name="booking_message" class="form-control" style="height:80px;" placeholder="Message for Doctor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @if(session()->has('user_id'))
                            <div style="position:relative;"><input type="submit" class="btn btn-primary" value="Book Now" id="submit-booking"></div>
                            @endif
                            @if(!session()->has('user_id'))
                                <div style="position:relative;"><a class="btn btn-info" id="submit-login" onclick="setLastPage()" href="{{route('auth.login')}}">Login to Book</a></div>
                            @endif
                        </form>
                    </div>
                    <!-- /box_general -->
                </aside>
                <!-- /asdide -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
@endsection
@section('footer-js')
    <script>
        function getRoutines(url){
            let clinic_id=document.getElementById('clinic_selector').value;
            let doctor_id=document.getElementById('doctor_id').value;
            document.getElementById('routine_date').value = null;
                document.getElementById('routine_date').disabled = false;



            $.ajax({
                url: "/get-routine/"+clinic_id+"/"+doctor_id,
            })
                .done(function(html) {
                    $("#routines_by_clinic").empty();
                    $("#routines_by_clinic").append(html);
                });
        }
    </script>
    <script>

        function getTimes(url){
            let date=document.getElementById('routine_date').value;
            let doctor_id=document.getElementById('doctor_id').value;
            let clinic_id=document.getElementById('clinic_selector').value;
            $.ajax({
                url: "/get-time/"+clinic_id+"/"+doctor_id+"/"+date,
            })
                .done(function(html) {
                    $("#time_options").empty();
                    $("#time_options").append(html);
                });
        }
    </script>
    <script>
        function setLastPage(){
            var now = new Date();
            var time = now.getTime();
            time += 3600 * 1000;
            now.setTime(time);
            document.cookie =
                'last_page=' + window.location.href +
                '; expires=' + now.toUTCString() +
                '; path=/';
        }
    </script>
@endsection

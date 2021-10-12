@extends('layouts.front')

@section('title')
    <title>Search Result - GetDoc</title>
@endsection
@section('content')
    <main>
        <div id="results">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Showing from of {{$count}} results!</h4>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /results -->



        <div class="container">
            <div class="row">
                <div id="search-result">
                    @foreach($result as $r)
                        <div class="strip_list wow fadeIn">
                            <a href="#0" class="wish_bt"></a>
                            <figure>
                                <img src="{{$r->link}}" alt="">
                            </figure>
                            <small>{{$r->designation}}</small>
                            <h3>{{$r->first_name}} {{$r->last_name}}</h3>
                            <p><span style="font-weight: bold">Specialities: </span>{{$r->specialities}}</p>
                            <a href="http://getdoc.com/doctor/{{$r->doctor_id}}"><button class="btn-primary">Book now</button></a>
                        </div>
                    @endforeach

{{--                    <nav aria-label="" class="add_top_20">--}}
{{--                        <ul class="pagination pagination-sm">--}}
{{--                            <li class="page-item disabled">--}}
{{--                                <a class="page-link" href="#" tabindex="-1">Previous</a>--}}
{{--                            </li>--}}
{{--                            <li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
{{--                            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                            <li class="page-item">--}}
{{--                                <a class="page-link" href="#">Next</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </nav>--}}
{{--                    <!-- /pagination -->--}}
                </div>
                <!-- /col -->

                <!-- /aside -->

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
@endsection
@section('footer-js')

@endsection

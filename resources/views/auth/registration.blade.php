@extends('layouts.auth')
@section('title')
    <title>Create Your Account</title>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-md-center login-area">
            <div class="col-md-5 col-md-5 login-box blurry">
                <div class="text-center">
                    <a href="{{route('home')}}"><img src="/assets/images/logo.png" height="100px" width="100px"></a><br><br>
                    <h2 class="text-aliceblue">Create {{ config('app.name') }} ACCOUNT</h2>
                    <hr>
                </div>
                <form class="form-row" method="post" action="{{route('store.registration')}}">
                    @csrf
                    @if (session('error'))
                        <script>swal("Error!", "{{ session('error') }}", "error");</script>
                        <div class="alert alert-danger">
                            {{ session('error') }}

                        </div>
                    @endif
                    @if (session('success'))
                        <script>swal("Good job!", "{{ session('success') }}", "success");</script>
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <input type="text" class="transparent-input form-control form-control-lg" name="username" placeholder="Enter username" required>

                    <input type="password" class="transparent-input form-control form-control-lg" name="password" placeholder="Enter password" required>
                    <input type="password" class="transparent-input form-control form-control-lg" name="conf_password" placeholder="Confirm password" required>
                    <select style="text-align-last:center;" class="transparent-input form-control form-control-lg" name="role" required>
                        <option disabled selected value> -- Choose User Type -- </option>
                        <option value="patient">Patient</option>
                        <option value="doctor">Doctor</option>
                        <option value="business">Business</option>
                    </select>
                    <br>
                    <div class="text-center">
                        <input class="btn btn-lg btn-block red-btn" type="submit" value="Sign Up">
                    </div>
                </form>
                <br>
                <div class="text-center">
                    <span>Already have an account?<a href="{{route('auth.login')}}"> Login Here</a></span>
                </div>
                <br>
                <div class="text-center">

                    <p>App Version: v {{ env('APP_VERSION') }}</p>
                </div>
            </div>

        </div>

    </div>
    </div>
@endsection

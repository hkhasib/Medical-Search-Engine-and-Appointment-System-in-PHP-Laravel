@extends('layouts.auth')
@section('title')
    <title>Reset Password - GetDoc</title>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-md-center login-area">
            <div class="col-md-5 col-md-5 login-box blurry">
                <div class="text-center">
                    <a href="{{route('home')}}"><img src="/assets/images/logo.png" height="100px" width="100px"></a><br><br>
                    <h2 class="text-aliceblue">Set Your New Password</h2>
                    <hr>
                </div>
                <div id="login-app">
                    <form class="form-row" method="post" action="{{route('auth.store.reset')}}">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif
                        <input type="hidden" name="user_id" value="{{$user_id}}" readonly required>
                        <input type="password" class="transparent-input form-control form-control-lg" name="password" placeholder="New Password" required>
                        <input type="password" class="transparent-input form-control form-control-lg" name="conf_password" placeholder="Confirm New Password" required>
                        <br>
                        <div class="text-center">
                            <input class="btn btn-lg btn-block red-btn" type="submit" value="Reset">
                        </div>
                    </form>
                </div>

                <br>
                <div class="text-center">
                    <div>
                        <p>Go Back to the <a href="{{route('auth.login')}}">Login Page</a></p>
                    </div><br>
                    <div>
                        <p>Don't have an account? <a href="{{route('auth.register')}}">Signup Here</a></p>
                    </div><br>
                    <div>
                        <p>App Version: v {{ env('APP_VERSION') }}</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

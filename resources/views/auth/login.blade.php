@extends('layouts.auth')
@section('title')
    <title>Login to Our Application</title>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-md-center login-area">
            <div class="col-md-5 col-md-5 login-box blurry">
                <div class="text-center">
                    <a href="{{route('home')}}"><img src="/assets/images/logo.png" height="100px" width="100px"></a><br><br>
                    <h2 class="text-aliceblue">LOGIN TO YOUR ACCOUNT</h2>
                    <hr>
                </div>
                <div id="login-app">
                    <form class="form-row" method="post" action="{{route('auth.verify')}}">
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
                        <input v-if="username" v-model="usernameValue" v-on:keyup="showPasswordField" type="text" class="transparent-input form-control form-control-lg" name="username" placeholder="username" required>

                        <input v-if="password" v-model="passwordValue" v-on:keyup="showLoginButton" type="password" class="transparent-input form-control form-control-lg" name="password" placeholder="password" required>
                        <div class="text-center">
                            <label>Remember Login:</label>
                            <input type="checkbox" name="remember" value="checked"><br>
                        </div>
                        <br>
                        <div class="text-center">
                            <input v-if="loginButton" :disabled="disabled" class="btn btn-lg btn-block login-btn" type="submit" value="Login">
                        </div>
                    </form>
                </div>

                <br>
                <div class="text-center">

                    <div>
                        <p>Don't have an account? <a href="{{route('auth.register')}}">Signup Here</a></p>
                    </div><br>
                    <p>Forgot Password? <a href="{{route('auth.reset')}}">Reset Now</a></p>
                    <div>
                        <p>App Version: v {{ env('APP_VERSION') }}</p>
                    </div>
                </div>

            </div>

        </div>
        <script src="{{mix('/js/app.js')}}"></script>
    </div>
@endsection


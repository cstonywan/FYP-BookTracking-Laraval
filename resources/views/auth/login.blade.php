@extends('layouts.app')
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
   
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
        <title>Book Tracking System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            html, body {
                background-color: #ffffff;
                color: #043364;
                font-family: 'Nunito', sans-serif;
                font-weight: 1000;
                height: 100%;
                margin: 0;   
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center center;
                background-image:url('icon/hkustbg4.jpg');             
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                padding-bottom:400px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #043364;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .a:hover{
                color:#ff8c1a;
            } 

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
   

@section('content')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-md-6" style="padding-top:200px">
            <div class="card" >
            
                <!-- <div class="card-header" style="color:#FFFFFF" align=center><strong>{{ __('Login') }}</strong></div>
             -->
             <div class="card-header" style="color:#FFFFFF;" align=center><strong>Welcome</strong></div>
                <div class="card-body" >
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row justify-content-md-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
                            <div class="col pt-1 col-md-2">
                                <img src="/icon/user.svg" height="30px" align="right">
                            </div>
                            <div class="col col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-3 form-group row justify-content-md-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
                            <div class="col pt-1 col-md-2">
                                <img src="/icon/lock-locked.svg" height="30px" align="right">
                            </div>
                            <div class="col col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required autocomplete="password" autofocus>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-7">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        

                        <div class="form-group row justify-content-md-center">
                            <div class="col col-md-8">
                                <button type="submit" class="btn btn-primary btn-block" >
                                   <strong>{{ __('Login') }}</strong>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row justify-content-md-center">
                        <div class="col col-md-8">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-block" role="button"  aria-pressed="true"><strong>Register</strong></a>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center">
                            <div class="col col-md-6 offset-md-8">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
</html>


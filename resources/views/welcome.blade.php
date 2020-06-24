@extends('layouts.app')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
        <title>Book Tracking System</title>
        <link rel="icon" href="{{ asset('icon/hkust.png') }}" type="image/png">

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
                background-image:url('icon/hkustbg1.jpg');             
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
                margin-bottom: 20px;
            }
        </style>
    </head>

    @section('content')
    <body>
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/b/search') }}" style="hover:color:#ff8c1a"><strong>Home</strong></a>
                    @else
                        <a href="{{ route('login') }}" style="hover:color:#ff8c1a"><strong>Login</strong></a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><strong>Register</strong></a>
                        @endif
                    @endauth
                </div>
            @endif -->

            <div class="content">
                <div class="title m-b-md">
                    Book Tracking System
                </div>
                <div class="row d-flex">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><strong>User Account</strong></div>
                            <div class="card-body">
                                <p>Email: user1@test.com</p>
                                <p>Password: 1234567890</p>
                                <br>
                                <p>Email: user2@test.com</p>
                                <p>Password: 1234567890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><strong>Manager Account</strong></div>
                            <div class="card-body">
                                <p>Email: manager1@test.com</p>
                                <p>Password: 1234567890</p>
                                <br>
                                <p>Email: manager2@test.com</p>
                                <p>Password: 1234567890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><strong>Admin Account</strong></div>
                            <div class="card-body">
                                <p>Email: admin1@test.com</p>
                                <p>Password: 1234567890</p>
                                <br>
                                <p>Email: admin2@test.com</p>
                                <p>Password: 1234567890</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    @endsection
</html>

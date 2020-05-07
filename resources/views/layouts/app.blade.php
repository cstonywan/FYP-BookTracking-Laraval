<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
 
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
   

    <title>Book Tracking System</title>

    <link rel="icon" href="{{ asset('icon/hkust.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var j = jQuery.noConflict();
           j( function() {
               j( $(".selectDate") ).datepicker({ dateFormat: "yy-mm-dd" });
           } );
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- CoreUI CSS -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css"> -->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- <a class="navbar-brand" href="{{ url('/') }}">
                    Book Tracking System
                </a> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('searchBook') }}">Search Book</a>
                            </li>
                            @if (Auth::user()->role == 0)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/borrow/record/' . Auth::user()->id ) }}">Borrow Record</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/b/track/28')}}">Track Book</a>
                            </li>
                            @if (Auth::user()->role >= 1)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/borrow/record/' . Auth::user()->id ) }}">Handled Record</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="manageDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                      Manage<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="manageDropdown">
                                        <a id="managebook" class="dropdown-item" href="{{ route('manageBook') }}" onclick="realTime()">Manage Book</a>
                                        <a class="dropdown-item" href="{{ route('manageBorrow') }}">Manage Lending</a>                                                                             
                                        @if (Auth::user()->role == 2)
                                        <a class="dropdown-item" href="{{ route('manageUser') }}">Manage User</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('manageRfid') }}">Rfid Setting</a>   
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="statisticDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                      Statistic<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="statisticDropdown">                                      
                                        <a class="dropdown-item" href="{{ route('showChart') }}">Rfid Testing Chart</a>                                      
                                    </div>
                                </li>
                            @endif
                        @endguest
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->photo !=null)
                                        <img src="/storage/{{ Auth::user()->photo }}" class="img-circle" style="width:40px;height:40px">
                                    @else
                                        <img src="/storage/photo/defaultuser.png" class="img-circle" style="width:40px;height:40px">
                                    @endif
                                    &nbsp;&nbsp;{{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('editProfile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/book_manage.js') }}"></script>
    <script src="{{ asset('js/user_manage.js') }}"></script>
    <script src="{{ asset('js/book_track.js') }}"></script>
    <script src="{{ asset('js/borrow.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
       <!-- For hide the alert -->
       window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
       }, 2000);    
       
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WWTL</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery.modal.css" type="text/css" rel="stylesheet" />
    <link href="/css/comm.css" rel="stylesheet">
    {{--<link href="/css/commPC.css" rel="stylesheet">--}}
    {{--<link href="/css/commMB.css" rel="stylesheet">--}}
    @yield('css')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    WWTL
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">What were they like.com</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a class="provision" data-href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img id="user-photo" src="{{Auth::user()->photo}}" />{{ Auth::user()->nick_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/user/mypage') }}">My Profile</a></li>
                                <li><a href="{{ url('/user/contact') }}">Contact</a></li>
                                @if(Auth::user()->admin_yn == 'Y')
                                <li><a href="{{ url('/admin/ratetype') }}">Admin</a></li>
                                @endif
                                <li><a href="{{ url('/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            @if(Request::is('/'))
            <p class="tit-main">WWTL</p>
            @endif
            <p class="tit-sub">
                <b>You can find anyone.</b>
                If you search by name, nick name, birthday, city, state or country.
                <b>You can rate anyone.</b>
                Rate your girlfriend, boyfriend, boss, ex-wife, ex-husband, the mail man, your plumber, teachers, parents. ANYONE!</p>
            <a class="btn btn-default btn-lg" id="btn-find">Find Someone</a> <a href="/rate/target/-1" class="btn btn-default btn-lg">Rate Someone</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="main">
                    <div class="background"></div>
                    <div>@yield('main')</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 col-xs-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div>@yield('content')</div>
            </div>
            <div class="col-sm-3 col-xs-12">advertisement area</div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/scripts/plugin/underscore.js"></script>
    <script src="/scripts/plugin/jquery.modal.min.js"></script>
    @yield('plugin')
    <script src="/scripts/common.js"></script>
    @yield('scripts')
</body>
</html>

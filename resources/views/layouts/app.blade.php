<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/login/login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/shared/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/locum/locum_find_a_job/locum_find_a_job.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/practice/practice_my_dashboard/practice_my_dashboard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/practice/practice_billing/practice_billing.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('angular/home/home.css') }}">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @stack('style')
</head>
<body>
    <div id="app">
        <nav class="col-lg-12 col-md-12 navbar navbar-default menu-nav-bar navbar_no_board locum-nav-bar admin-nav-bar" id="adminNav">
            <div class="container-fluid menu-bar menu-bar-locum">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar custom-icon-bar"></span>
                        <span class="icon-bar custom-icon-bar"></span>
                        <span class="icon-bar custom-icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand logo logo-locum" href="{{route('corporation/home')}}"><img src="{{ asset('img/admin-logo.png') }}" class="img-responsive" alt="Responsive image"/></a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                    @if (session('user') && session('user')->role )
                        <li class="{{Request::is('corporation/home') ? 'active' : ''}}"><a class="navbar-brand page-name-admin col-xs-12"  href="{{ route('corporation/home') }}">Corporations</a></li>
                        <li class="{{Request::is('news_list') ? 'active' : ''}}"><a class="navbar-brand page-name-admin col-xs-12"  href="{{ route('news_list') }}">News</a></li>
                    @elseif(session('user'))
                            <li class="{{Request::is('corporation_invoices') ? 'active' : ''}}"><a class="navbar-brand page-name-admin"  href="{{ route('corporation_invoices') }}">Invoices</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                       @if (!session('user'))
                            <li><a href="/#!/home" class="page-name-admin">Home</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle page-name-admin custom-style" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ session('user')->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if(!session('user')->role)
                                    <li>
                                        <a href="{{ route('corporation/password') }}">Change password</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('corporation/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('corporation/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <div class="container-fluid footer footer-locum" ng-if="checkForURLFooter()">
            <div class="text-center">
                <img src="{{ asset('img/logo.png') }}" class="img-responsive center-block" alt="Responsive image" />
                <p class="company-address locum-company-address">Copyright 2017 © Locum OD. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Scripts -->
    @stack('scripts')

</body>
</html>

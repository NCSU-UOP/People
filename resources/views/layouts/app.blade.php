<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="University-wide Verified Data Collection of University Personnel">
    <meta name="theme-color" content="#8a0008"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('minifiedjs/app.min.js') }}" defer></script>
    <script src="/js/index.js" defer></script>
    <script src="{{ asset('vendor/aos/aos.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha384-ZvpUoO/+PpLXR1lu4jmpXWu80pZlYUAfxl5NsBMWOEPSjUn/6Z/hRTt8+pR6L4N2" crossorigin="anonymous"></script>
    @yield('profile-page-js')
    @yield('admin-page-js')
    @yield('excelupload-page-js')
    @yield('landing-page-js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet" />
    @yield('landing-page-css')
    @yield('admin-page-css')
    @yield('css-header')

    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <!-- apple touch icon -->
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.ico') }}">
</head>
    
<body class="d-flex flex-column min-vh-100">

    <div class="cssload-loader" id='preloader'>
	<div class="cssload-inner cssload-one"></div>
	<div class="cssload-inner cssload-two"></div>
	<div class="cssload-inner cssload-three"></div>
    </div>

    <div id="app">
        <button type="button" class="btn btn-warning btn-floating btn-lg" id="btn-back-to-top" style="position: fixed; bottom: 10px; right: 20px; display: none; z-index:100;"><i class="bi bi-chevron-up"></i></button>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background-image: linear-gradient(to right, #4e0000, #8b0008);">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo.png" alt="" style="height:60px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="underline nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="underline nav-link" href="/people">People</a>
                        </li>
                        @if(Auth::user())
                            @if(Auth::user()->usertype == env('ADMIN'))
                                <li class="nav-item">
                                <a class="underline nav-link" href="/dashboard">Dashboard</a>
                                </li>
                            @elseif(Auth::user()->usertype == env('STUDENT'))
                                <li class="nav-item">
                                <a class="underline nav-link" href="{{route('people.profile', ['username' => Auth::user()->username])}}">Profile</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                            <a class="underline nav-link" href="/form">Form</a>
                            </li>
                        @endif

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="underline nav-link" href="{{ route('login') }}" >{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="underline nav-link" href="{{ route('register') }}" >{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="underline nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @yield('navbar-item')
                                    @if(Auth::user()->admins()->first()->is_admin === 1)
                                        <a href="/dashboard/add/user" class="dropdown-item">Add new user</a>
                                        <a href="/dashboard/add/excelfile" class="dropdown-item">Add new excel file</a>
                                        <a href="/dashboard/add/faculty" class="dropdown-item">Add/Edit faculty details</a>
                                        <a href="/dashboard/add/batch" class="dropdown-item">Add/Edit batch details</a>
                                        <a href="/dashboard/add/department" class="dropdown-item">Add Department</a>
                                        <a href="/activity" class="dropdown-item">View site activity</a>
                                    @endif
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @yield('background-img')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('superAdminCharts')
    @yield('AdminCharts')
    <div class="block mt-auto" id='app-footer'>
        <div class="container" >
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top mt-auto">
            <p class="col-sm-4 mb-0 text-muted">© 2022 University of Peradeniya</p>
            <a href="https://www.pdn.ac.lk/ncsu/"><img class="col-sm-4 d-flex justify-content-between" src="/img/ncsuicon.png" alt="ncsu icon" style="width: 130px; height: 40px;"/></a>
            <p class="col-sm-4 mb-0 text-muted d-flex justify-content-end">All rights reserved.</p>
            </footer>
        </div>
    </div>

    <script>
    /**
     * Preloader
     */
    window.addEventListener("load", function() {
    var load_screen = document.getElementById("preloader");
    document.body.removeChild(load_screen);
    document.getElementById('app').classList.add('ready');
    document.getElementById('app-footer').classList.add('ready');
    });
    </script>  
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>
@yield('profile-page-scripts')
@yield('scripts-footer')
@yield('search-script')
@yield('admin-page-scripts')
@yield('admin-page-scripts2')
@yield('excel-preview-script')
</body>
</html>

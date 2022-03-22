<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/index.js" defer></script>
    <script src="{{ asset('vendor/aos/aos.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/1c62222909.js" crossorigin="anonymous"></script>
    @yield('profile-page-js')
    @yield('clickablerow-script')
    @yield('addtitle-script')
    @yield('confirmmodal-script')
    @yield('datatable-script')
    @yield('tooltip-script')
    @yield('styles')
    @yield('loggerscripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet" />
    @yield('landing-page-css')

    <!-- favicon -->
    <link rel="icon" href="img/favicon.png">
    <!-- apple touch icon -->
    <link rel="apple-touch-icon" href="img/favicon.png">
</head>
    
<body class="d-flex flex-column min-vh-100">

    <div class="cssload-loader" id='preloader'>
	<div class="cssload-inner cssload-one"></div>
	<div class="cssload-inner cssload-two"></div>
	<div class="cssload-inner cssload-three"></div>
    </div>

    <div id="app">
        <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top" style="position: fixed; bottom: 10px; right: 20px; display: none;"><i class="bi bi-arrow-bar-up"></i></button>
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
                            <a class="nav-link" href="/" style="color: white;">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/people" style="color: white;">People</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/forum" style="color: white;">Forum</a>
                        </li>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color: white;">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}" style="color: white;">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: white;">
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->usertype == env('ADMIN'))
                                    <a href="/dashboard" class="dropdown-item">Dashboard</a>
                                    @endif

                                    @yield('navbar-item')
                                    
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
    
    <div class="block mt-auto" id='app-footer'>
        <div class="container" >
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mt-auto">
            <p class="col-md-4 mb-0 text-muted">© 2022 University of Peradeniya</p>
            <p class="col-md-0 mb-0 text-muted">All rights reserved.</p>
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
@yield('landing-page-scripts')
@yield('profile-page-scripts')
</body>
</html>

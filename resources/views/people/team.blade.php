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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet"/>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />
    <!-- Landing page custom CSS File -->
    <!-- <link href="{{ asset('css/landingpage.css') }}" rel="stylesheet" /> -->

    <style>
    /*--------------------------------------------------------------
    # Sections General
    --------------------------------------------------------------*/
    section {
        padding: 10px 0;
        overflow: hidden;
    }

    .section-bg {
        background-color: #f8fbfe;
    }

    .section-title {
        text-align: center;
        padding-bottom: 30px;
    }
    .section-title h2 {
        font-size: 32px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        padding-bottom: 0;
        color: #8a0008;
    }
    .section-title p {
        margin-bottom: 0;
        font-size: 14px;
        color: #919191;
    }     
    /*--------------------------------------------------------------
    # Team
    --------------------------------------------------------------*/
    .team .member {
    margin-bottom: 20px;
    overflow: hidden;
    text-align: center;
    border-radius: 4px;
    background: #fff;
    box-shadow: 0px 2px 15px rgba(18, 66, 101, 0.08);
    }
    .team .member .member-img {
    position: relative;
    overflow: hidden;
    }
    .team .member .social {
    position: absolute;
    left: 0;
    bottom: 0;
    right: 0;
    height: 40px;
    opacity: 0;
    transition: ease-in-out 0.3s;
    text-align: center;
    background: rgba(255, 255, 255, 0.85);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    }
    .team .member .social a {
    transition: color 0.3s;
    color: #124265;
    margin: 0 10px;
    display: inline-block;
    }
    .team .member .social a:hover {
    color: #2487ce;
    }
    .team .member .social i {
    font-size: 18px;
    margin: 0 2px;
    line-height: 0;
    }
    .team .member .member-info {
    padding: 25px 15px;
    }
    .team .member .member-info h4 {
    font-weight: 700;
    margin-bottom: 5px;
    font-size: 18px;
    color: #124265;
    }
    .team .member .member-info span {
    display: block;
    font-size: 13px;
    font-weight: 400;
    color: #aaaaaa;
    }
    .team .member .member-info p {
    font-style: italic;
    font-size: 14px;
    line-height: 26px;
    color: #777777;
    }
    .team .member:hover .social {
    opacity: 1;
    }
    </style>

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
        <main class="py-4">       
        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
            <h2>Team</h2>
            <p>
                This project was done by following 4 Computer Engineering Undergraduates of University of Peradeniya 
                in their internship period in 2022.
            </p>
            </div>

            <div class="row">
            <div
                class="col-lg-3 col-md-6 d-flex align-items-stretch"
                data-aos="fade-up"
                data-aos-delay="100"
            >
                <div class="member">
                <div class="member-img">
                    <img
                    src="img/1.jpg"
                    class="img-fluid"
                    alt=""
                    />
                    <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Nadun Welikanda</h4>
                    <span>E/16/369</span>
                </div>
                </div>
            </div>

            <div
                class="col-lg-3 col-md-6 d-flex align-items-stretch"
                data-aos="fade-up"
                data-aos-delay="200"
            >
                <div class="member">
                <div class="member-img">
                    <img
                    src="img/2.jpg"
                    class="img-fluid"
                    alt=""
                    />
                    <div class="social">
                    <a href="https://twitter.com/IsuruLa15041907"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.facebook.com/isuru.lakshan.58323431/"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/isurulakshan97/"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/isurulakshan/"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Isuru Lakshan</h4>
                    <span>E/16/203</span>
                </div>
                </div>
            </div>

            <div
                class="col-lg-3 col-md-6 d-flex align-items-stretch"
                data-aos="fade-up"
                data-aos-delay="300"
            >
                <div class="member">
                <div class="member-img">
                    <img
                    src="img/3.jpg"
                    class="img-fluid"
                    alt=""
                    />
                    <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="member-info">
                    <h4>J.P.D.M Chandula</h4>
                    <span>E/16/061</span>
                </div>
                </div>
            </div>

            <div
                class="col-lg-3 col-md-6 d-flex align-items-stretch"
                data-aos="fade-up"
                data-aos-delay="400"
            >
                <div class="member">
                <div class="member-img">
                    <img
                    src="img/4.jpg"
                    class="img-fluid"
                    alt=""
                    />
                    <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Tharushi Suwaris</h4>
                    <span>E/16/200</span>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
            <!-- End Team Section -->
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
    <a
      href="#"
      class="back-to-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
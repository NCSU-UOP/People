@extends('layouts.app')

@section('landing-page-css')
<!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />

    <!-- Landing page custom CSS File -->
    <link href="{{ asset('css/landingpage.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
      <div
        class="container position-relative"
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <div class="row justify-content-center">
          <div class="col-xl-7 col-lg-9 text-center">
            <h1>Data Aquisition Project</h1>
            <h2>University-wide Verified Data Collection of University Personnel</h2>
          </div>
        </div>
        <div class="text-center">
          <a href="#about" class="btn-get-started scrollto">Explore</a>
        </div>

        <div class="row icon-boxes">
          <div
            class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
            data-aos="zoom-in"
            data-aos-delay="200"
            style="justify-content: center;"
          >
            <div class="icon-box">
              <div class="icon"><i class="ri-user-2-fill"></i></div>
              <h4 class="title"><a href="">Academic Staff</a></h4>
              <p class="description">
                500+
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
            data-aos="zoom-in"
            data-aos-delay="300"
            style="justify-content: center;"
          >
            <div class="icon-box">
              <div class="icon"><i class="ri-team-fill"></i></div>
              <h4 class="title"><a href="">Students</a></h4>
              <p class="description">
                10000+
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
            data-aos="zoom-in"
            data-aos-delay="400"
            style="justify-content: center;"
          >
            <div class="icon-box">
              <div class="icon"><i class="ri-user-star-fill"></i></div>
              <h4 class="title"><a href="">Registered Graduates</a></h4>
              <p class="description">
                15000+
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
            data-aos="zoom-in"
            data-aos-delay="500"
            style="justify-content: center;"
          >
            <div class="icon-box">
              <div class="icon"><i class="ri-group-fill"></i></div>
              <h4 class="title"><a href="">Non-Academic Staff</a></h4>
              <p class="description">
                1000+
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero -->

    <!-- ======= About Section ======= -->
      <section id="about" class="about">
        <div class="container">
          <div class="section-title" data-aos="fade-up">
            <h2>About</h2>
            <p>
              This website is created and managed by Network and Communication Services
              Unit(NCSU) of University of Peradeniya. This project is done in order to fulfill the requirement to gather information to provide single sign on(SSO)
              access to university resources & provide a verified university profile for all the relevent personnel who are currrently studying, who have studied,
              who are teaching and working within the university.
            </p>
          </div>

          <div class="content">
            <div data-aos="fade-up">
              <p>Following steps are expected to be followed when registering</p>
            </div>
              <ul>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> Students & Staff need to submit their basic information through a form.
                </li>
                </div>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> Find and fill the correct form and submit 
                </li>
                </div>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> Upon Succcessfull submission of information you will receive an Email to the provided address
                </li>
                </div>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> Each form submission is then go through a verificatiion process by a Faculty Representative
                </li>
                </div>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> Verified Information will be displayed under people section
                </li>
                </div>
                <div data-aos="fade-up">
                <li>
                  <i class="ri-check-double-line"></i> All verified information will be publicly accessible
                </li>
                </div>
              </ul>
          </div>
        </div>
      </section>
      <!-- End About Section -->

@endsection

@section('footer')
  <div class="block">
    <div class="container" >
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">© 2022 University of Peradeniya</p>

        <ul class="nav col-md-4 justify-content-end">
          <p>All rights reserved</p>
        </ul>

      </footer>
    </div>
  </div>
@endsection


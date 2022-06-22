@extends('layouts.app')

@section('landing-page-css')
<!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />

    <!-- Landing page custom CSS File -->
    <link href="{{ asset('css/landingpage.css') }}" rel="stylesheet" />
@endsection

@section('landing-page-js')
    <!-- Landing page particle style JS File -->
    <script src="/minifiedjs/particleWave.min.js" defer></script>
@endsection

@section('content')
  @if(session()->has('message'))
  <div class="alert alert-{{session()->get('color')}} alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="padding-bottom: 200px">
      <div
        class="container position-relative"
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <div class="row justify-content-center">
          <div class="col-xl-7 col-lg-9 text-center" style="user-select: none;">
            <h1>Data Aquisition Project</h1>
            <h2>University-wide Verified Data Collection of University Personnel</h2>
          </div>
        </div>
        <div class="text-center">
          <!-- <button class="ctrl-standard typ-subhed fx-bubbleUp">EXPLORE</button> -->
          <div id="buttonContainer">
            <div class="button" id="button-style">
            <div id="circle"></div>
            <a href="/people" style="font-weight: bold; letter-spacing: 1.5px;">EXPLORE</a>
            </div>
          </div>
        </div>
        <div style="position: relative; padding-top: 100px; height: 100px width: 100px"></div>
      </div>
      <div id="anim" class="containeranim animate-style">
      <div id="anim1"></div>
      </div>
    </section>
    <!-- End Hero -->

    <!-- ======= About Section ======= -->
      <section id="about" class="about">
        <div class="container" style="user-select: none;">
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
    <div class="container" style="user-select: none;">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">© 2022 University of Peradeniya</p>

        <ul class="nav col-md-4 justify-content-end">
          <p>All rights reserved</p>
        </ul>

      </footer>
    </div>
  </div>
@endsection


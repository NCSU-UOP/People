@extends('layouts.app')

@section('content')
<div
        class="container position-relative"
        data-aos="fade-up"
        data-aos-delay="100"
      >
<h1 class="text-center" style='margin: 0;
    font-size: 56px;
    font-weight: 700;
    line-height: 72px;
    color: #9D170E;
    font-family: "Poppins", sans-serif;' >Coming Soon!</h1>
<h2 class="text-center" style='color: #5e5e5e;
    margin: 10px 0 0 0;
    font-size: 22px;' >We are almost there, Stay Tuned!</h2>
<div class="text-center">
          <a href="{{ url()->previous() }}" class="scrollto" style='font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 0.5px;
    display: inline-block;
    padding: 14px 50px;
    border-radius: 5px;
    transition: 0.5s;
    margin-top: 30px;
    color: #fff;
    background: #2487ce;'>Go Back</a>
</div>
</div>
<div    class="container position-relative"
        data-aos="zoom-in-up"
        data-aos-delay="100">
<div class="text-center pt-5">
    <img src="/img/icon.png" alt="ncsuicon">
</div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container p-2 pb-4 rounded">
    <h1 class="text-center font-weight-bold">Form Selection</h1>
</div>

<div class="container" style="display: flex; justify-content:center;">
    <div class="row" style="justify-content:center;" data-aos="zoom-in" data-aos-delay=100>
    <!-- <div class="col-sm-6" data-aos="zoom-in" data-aos-delay=100> -->
        <div class="card bg-light mb-3 mx-3" style="max-width: 18rem;">
            <div class="card-header text-center">Academic Staff</div>
            <img class="card-img-top" src="/img/staff.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Academic Staff Form</h5>
                <p class="card-text">Academic staff should fill this form to create an account.</p>
                <a href="/form/academic" class="btn btn-primary">Visit</a>
            </div>
        </div>
    <!-- </div> -->

    <!-- <div class="col-sm-6" data-aos="zoom-in" data-aos-delay=200> -->
        <div class="card bg-light mb-3 mx-3" style="max-width: 18rem;">
            <div class="card-header text-center">Students</div>
            <img class="card-img-top" src="/img/student.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Student Form</h5>
                <p class="card-text">Students should fill this form to create and account.</p>
                <a href="/form/student" class="btn btn-primary">Visit</a>
            </div>
        </div>
    <!-- </div> -->

    <!-- <div class="col-sm-6" data-aos="zoom-in" data-aos-delay=100> -->
        <div class="card bg-light mb-3 mx-3" style="max-width: 18rem;">
            <div class="card-header text-center">Non-Academic Staff</div>
            <img class="card-img-top" src="/img/non-academic.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Non-Academic Staff Form</h5>
                <p class="card-text">Non-Academic staff should fill this form to create an account</p>
                <a href="/form/nonacademic" class="btn btn-primary">Visit</a>
            </div>
        </div>
    <!-- </div> -->
    </div>
</div>
@endsection


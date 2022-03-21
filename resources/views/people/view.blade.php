@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-9">
        <form class="card card-sm text-center">
        <div class="card-body row no-gutters align-items-center">
            <div class="col">
                <div class="input-group">
                        <span class="input-group-text text-primary border-primary" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                        <input class="form-control border-primary" type="search" placeholder="Search people.pdn.ac.lk " id="search-input" autofocus="">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Advanced</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/search/by-name">by Name</a></li>
                        <li><a class="dropdown-item" href="/search/by-reg-no">by Registration Number</a></li>
                        <li><a class="dropdown-item" href="/search/by-contact-number">by Contact Number</a></li>
                        <li><a class="dropdown-item" href="/search/by-location">by Location</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
</div>

<div class="container pt-4" style="display: flex; justify-content:center;">
    <div class="row" style="justify-content:center;">
        <div class="card bg-light m-3" style="max-width: 18rem;">
            <div class="card-header text-center">Academic Staff</div>
            <img class="card-img-top" src="/img/staff.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Academic Staff Catalogue</h5>
                <p class="card-text">Click Explore button to view Academic staff details</p>
            </div>
            <a href="people/academic" type="button" class="btn btn-outline-secondary btn-block mb-3">Explore</a>
        </div>
        <div class="card bg-light m-3" style="max-width: 18rem;">
            <div class="card-header text-center">Students</div>
            <img class="card-img-top" src="/img/student.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Student Catalogue</h5>
                <p class="card-text">Click Explore button to view Students details</p>
            </div>
            <a href="people/student" type="button" class="btn btn-outline-secondary btn-block mb-3">Explore</a>
        </div>
        <div class="card bg-light m-3" style="max-width: 18rem;">
            <div class="card-header text-center">Non-Academic Staff</div>
            <img class="card-img-top" src="/img/non-academic.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Non-academic Catalogue</h5>
                <p class="card-text">Click Explore button to view Non-academic staff details</p>
            </div>
            <a href="#" type="button" class="btn btn-outline-secondary btn-block mb-3">Explore</a>
        </div>
    </div>
    </div>
</div>
@endsection


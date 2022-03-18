@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bg-primary p-3 pb-1 rounded" style="--bs-bg-opacity: .1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/people">People</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container d-flex flex-wrap pt-4">
    <div class="col-md-2">
        <img src="/img/default.png" class="img-thumbnail" alt="Profile image">
        <h4 class="pt-4"> Chandula J.P.D.M.</h4>
        <h5 class="text-muted"> @chandula</h5>
        <div class="d-grid gap-2 pt-2">
            <button type="button" class="btn btn-outline-dark btn-block"> Edit Profile </button>
            <button type="button" class="btn btn-outline-dark btn-block"> Reset Password </button>
        </div>
    </div>

    <div class="col-md-10 ps-2">
        <div class="container pb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> #Profile </h4>
                </div>
            </div>
        </div>
        
        <div class="container pb -4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> #Profile </h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
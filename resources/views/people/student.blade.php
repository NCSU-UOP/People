@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bg-primary p-3 pb-1 rounded" style="--bs-bg-opacity: .1;">
        <h1>Student</h1>
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
        <div class="col-md-4 px-4">
            <div class="row">
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseAgri" aria-expanded="false" aria-controls="collapseAgri">Faculty of Agriculture</button>
                <div class="collapse mb-3" id="collapseAgri">
                    <div class="card card-body">
                    <a href="/people/student/AG/16" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/AG/17" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/AG/18" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/AG/19" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseAHS" aria-expanded="false" aria-controls="collapseAHS">Faculty of Allied Health Science</button>
                <div class="collapse mb-3" id="collapseAHS">
                    <div class="card card-body">
                    <a href="/people/student/AHS/16" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/AHS/17" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/AHS/18" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/AHS/19" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseArt" aria-expanded="false" aria-controls="collapseArt">Faculty of Arts</button>
                <div class="collapse mb-3" id="collapseArt">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-4">
            <div class="row">
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseDental" aria-expanded="false" aria-controls="collapseDental">Faculty of Dental Science</button>
                <div class="collapse mb-3" id="collapseDental">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseEng" aria-expanded="false" aria-controls="collapseEng">Faculty of Engineering</button>
                <div class="collapse mb-3" id="collapseEng">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseMng" aria-expanded="false" aria-controls="collapseMng">Faculty of Managment</button>
                <div class="collapse mb-3" id="collapseMng">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-4">
            <div class="row">
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseMed" aria-expanded="false" aria-controls="collapseMed">Faculty of Medicine</button>
                <div class="collapse mb-3" id="collapseMed">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseSci" aria-expanded="false" aria-controls="collapseSci">Faculty of Science</button>
                <div class="collapse mb-3" id="collapseSci">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapseVet" aria-expanded="false" aria-controls="collapseVet">Faculty of Veterinary Medicine & Animal Science</button>
                <div class="collapse mb-3" id="collapseVet">
                    <div class="card card-body">
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">16 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">17 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">18 batch</a>
                    <a href="/people/student/" type="button" class="btn btn-outline-secondary mb-2">19 batch</a>
                    </div>
                </div>
            </div>
        </div>
        
</div>
@endsection
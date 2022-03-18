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

<div class="container pt-4">
    <div class="row gutters-sm ">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/img/default.png" alt="image" style="border-radius: 10%" width="200">
                        <div class="mt-2"><h4>Chandula J.P.D.M.</h4></div>
                        <h5 class="text-muted"> @chandula</h5>
                    </div>
                    <div class="d-flex flex-column border border-3 mt-3 p-3">
                        <h4> Bio </h4>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laboriosam natus tenetur voluptas</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
            <div class="card-header" style="font-weight: 1000"><i class="bi bi-messenger"></i>  Social Media</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"> <i class="fas fa-address-card"></i> CV</h6>
                        <span class="text-secondary"> <a href="https://drive.google.com/file/d/1dQP-suGSF7Svg9kKKyBuhXnQAifa3dSt/view?usp=sharing" target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">View</button></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"> <i class="fab fa-linkedin"></i> LinkedIn</h6>
                        <span class="text-secondary"> <a href="https://linkedin.com/in/isuri-devindi-b8602a206" target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">View</button></a></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"> <i class="fab fa-github"></i> Github</h6>
                        <span class="text-secondary"> <a href="https://github.com/Isuri-Devindi" target="_blank"><button type="button" class="btn btn-outline-primary btn-sm">View</button></a></span>
                    </li>
                </ul>
            </div>
        </div>
    
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header" style="font-weight: 1000"><i class="bi bi-person-fill"></i> Profile</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Full Name</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Madushan Chandula
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Preferred Name</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            J.P.D.M. Chandula
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Faculty</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Faculty of Engineering
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Registration Number</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            E/16/061
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Department</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Department of Computer Engineering
                        </div>
                    </div>
                </div>    
            </div>

            <div class="card mb-3">
            <div class="card-header" style="font-weight: 1000"><i class="bi bi-person-lines-fill"></i>  Contact details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Email</span>
                    </div>
                    <div class="col-sm-9 text-secondary">e16061@eng.pdn.ac.lk</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Address</span>
                    </div>
                    <div class="col-sm-9 text-secondary">158/c, 1st Lane, Neelammahara, Boralesgamuwa</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">City</span>
                    </div>
                    <div class="col-sm-9 text-secondary">Boralesgamuwa</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Province</span>
                    </div>
                    <div class="col-sm-9 text-secondary">Western</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Telephone No.</span>
                    </div>
                    <div class="col-sm-9 text-secondary">0778375430</div>
                </div>
            </div>
            </div>

        </div>
                    <!-- <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Email</span>
                        </div>
                        <div class="col-sm-9 text-secondary">e17058@eng.pdn.ac.lk<br>gaisuridevindi@gmail.com</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Location</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Kandy
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Interests</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Computer Vision, Machine Learning, Technical Writing
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Current Affiliation</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Department of Computer Engineering, University of Peradeniya
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="font-weight: 500">Projects</div>
                <div class="card-body mx-2">
                <div class="row"><div class="card my-1 p-0 img-hover-zoom-card">
                    <div class="row g-0">
                    <div class="col-md-3 col-sm-3 d-flex align-items-center">
                        <div class="img-hover-zoom">
                            <img class="card-img-top app-thumb-img img-fluid" src="https://projects.ce.pdn.ac.lk/data/categories/3yp/thumbnail.jpg" alt="remote proctoring system">
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 ">
                        <div class="card-body">
                            <h6 class="">remote proctoring system</h6>
                            <div class="card-text d-flex justify-content-between pt-2">
                                <i>Cyber-Physical Systems Projects</i>
                                <a href="https://projects.ce.pdn.ac.lk/3yp/e17/remote-proctoring-system/" target="_blank"><button type="button" class="btn btn-outline-primary btn-sm ms-auto">View</button></a>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                <div class="card my-1 p-0 img-hover-zoom-card">
                    <div class="row g-0">
                        <div class="col-md-3 col-sm-3 d-flex align-items-center">
                            <div class="img-hover-zoom">
                                <img class="card-img-top app-thumb-img img-fluid" src="https://projects.ce.pdn.ac.lk/data/categories/co328/thumbnail.jpg" alt="Oral Cavity Region Detection">
                            </div>
                    </div>
                    <div class="col-md-9 col-sm-9 ">
                        <div class="card-body">
                            <h6 class="">Oral Cavity Region Detection</h6>
                            <div class="card-text d-flex justify-content-between pt-2">
                                <i>Software Engineering Projects (CO328)</i>
                                <a href="https://projects.ce.pdn.ac.lk/co328/e17/Oral-Cavity-Region-Detection/" target="_blank"><button type="button" class="btn btn-outline-primary btn-sm ms-auto">View</button></a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<!-- <div class="container d-flex flex-wrap pt-4 justify-content-center">
    <div class="col-md-2 pb-4">
        <img src="/img/default.png" class="img-thumbnail" alt="Profile image">
        <h4 class="pt-4"> Chandula J.P.D.M.</h4>
        <h5 class="text-muted"> @chandula</h5>
        <div class="d-grid gap-2 pt-2">
            <button type="button" class="btn btn-outline-dark btn-block"> Edit Profile </button>
            <button type="button" class="btn btn-outline-dark btn-block"> Reset Password </button>
        </div>
    </div>

    <div class="col-md-10 ps-2" style="min-width: 23rem;">
        <div class="row">
        <div class="container pb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> #Profile </h5>
                </div>
            </div>
        </div>
        </div>
        
        <div class="row">
        <div class="container pb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> #Contact Details </h5>
                </div>
            </div>
        </div>
        </div>

        <div class="row">
        <div class="container pb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> #Social media Links </h5>
                </div>
            </div>
        </div>
        </div>

        <div class="row">
        <div class="container pb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> #Projects </h5>
                </div>
            </div>
        </div>
        </div>
    </div> -->
</div>
@endsection
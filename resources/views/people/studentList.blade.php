
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="bg-primary p-3 pb-1 rounded" style="--bs-bg-opacity: .1;">
        <h1>Student List</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/people">People</a></li>
                <li class="breadcrumb-item"><a href="/people/student">Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$facultyName}} / {{$batch}}</li>
            </ol>
        </nav>
    </div>
</div>

    <!-- student cards -->
    
   <div class="row justify-content-center pt-3 pb-5">
       @if ($studentlist)
        @php $delay = 100;@endphp
        @foreach($studentlist as $data)
        <div class="card text-center p-2 m-1 border-primary" data-aos="zoom-in" data-aos-delay={{$delay}} style="width: 11rem;">
                <img src={{$data['image']}} style = "border-radius: 7%; height:158px;object-fit: cover;" class="card-img-top p-1" alt="">
            <div class="card-body d-flex flex-column">
                <h6 class="card-title">
                        {{$data['fullname']}}
                    </h6>
                <p class="card-text">{{$data['regNo']}}</p>
                <div class="d-flex flex-row justify-content-center mt-auto">
                        <a class="btn btn-outline-primary w-100" href="/people/student/{{$data['id']}}">View</a>
                </div>
            </div>
        </div>
        @php $delay = $delay+100; @endphp
        @endforeach
       @else
        <div class='row justify-content-center p-5'>
        <div class="card text-dark bg-warning" data-aos="zoom-in" style="max-width: 540px;">
            <h5 class="card-header text-center" data-aos="zoom-in">Oops!</h5>
            <div class="card-body">
                <h5 class="card-title text-center" data-aos="zoom-in" data-aos-delay=200>No Verified Students from {{$facultyName}}, Batch {{$batch}} yet!</h5>
                <p class="card-text text-center" data-aos="zoom-in" data-aos-delay=250>Please Come again later!</p>
                <div class="text-center">
                <a href="/people/student" class="btn btn-primary" data-aos="zoom-in" data-aos-delay=300>Go back</a>
                </div>
            </div>
        </div>
        </div>
       @endif
   </div>

@endsection
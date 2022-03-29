
@extends('layouts.app')

@section('content')
<main class="container">
    <h1>{{$facName}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Unverified Students</li>
            <li class="breadcrumb-item active" aria-current="page">{{$batch}}</li>

        </ol>
    </nav>
</main>
<div class="container py-4 px-lg-5">
    <div class="row justify-content-center pb-5">
        @foreach($studentList as $stdList)
            <div class="card text-center p-2 m-1 border-primary" style="width: 11rem;">    
                <img src={{$stdList->image}} style="border-radius: 7%; height:158px;object-fit: cover;" class="card-img-top p-1" alt="">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">
                        {{$stdList->initial}}
                    </h6>
                    <p class="card-text">{{ $stdList->regNo}}</p>
                    <div class="d-flex flex-row justify-content-center mt-auto">
                        <a class="btn btn-outline-primary w-100" href="/unverifiedStudent/{{ $stdList->id}}">View</a>
                    </div>
                </div>
            </div>
        @endforeach    
    </div>
</div>

@endsection
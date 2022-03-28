
@extends('layouts.app')

@section('content')

@if($list === 1)
<div class="p-3 pb-3 rounded">
    <h1 class="text-center font-weight-bold">Unverified Students List</h1>
</div>

<div class="container py-4 px-lg-5">
    <div class="row justify-content-center pb-5">
        @foreach($studentList as $stdList)
            <div class="card text-center p-2 m-1 border-primary" style="width: 11rem;">    
                
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">
                        {{$stdList['initial']}}
                    </h6>
                    <p class="card-text">{{$stdList['regNo']}}</p>
                    <div class="d-flex flex-row justify-content-center mt-auto">
                        <a class="btn btn-outline-primary w-100" href="/{{$stdList['id']}}">View</a>
                    </div>
                </div>
            </div>
        @endforeach    
    </div>
</div>
@else

@endif

@endsection
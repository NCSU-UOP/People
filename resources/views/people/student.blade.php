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

<div class="container d-flex flex-wrap pt-4" id="parent">
    <div class="col-md-4 px-4">
        <div class="row">
    @php $count = 0; $delay = 100;@endphp
    @foreach($fac as $data)
            <button type="button" data-aos="zoom-in" data-aos-delay={{$delay}} class="btn btn-outline-primary btn-block mb-3" data-bs-toggle="collapse" data-bs-target="#collapse{{$data['code']}}" aria-expanded="false" aria-controls="collapse{{$data['code']}}">{{$data['name']}}</button>
            <div class="collapse mb-3" id="collapse{{$data['code']}}" data-bs-parent="#parent">
                <div class="card card-body">
                @foreach($batches as $batch)
                    <a href="/people/student/{{$data['code']}}/{{$batch['id']}}" type="button" class="btn btn-outline-secondary mb-2">{{$batch['id']}} batch</a>
                @endforeach
                </div>
            </div>
            @php $count = $count+1; $delay = $delay+100; @endphp
            @if ($count == 3)
                    </div>
                </div>
                <div class="col-md-4 px-4">
                    <div class="row">
                @php $count = 0; @endphp
            @endif
    @endforeach
        </div>
    </div>
</div>
@endsection
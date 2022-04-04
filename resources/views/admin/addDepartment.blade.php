@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register a Department - {{$facultyName}}</div>

                <div class="card-body">
                    <form method="POST" action="/dashboard/{{$facultyName}}/add/department" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="departmentname" class="col-md-4 col-form-label text-md-end">Department Name</label>

                            <div class="col-md-6">
                                <input id="departmentname" type="departmentname" class="form-control @error('departmentname') is-invalid @enderror" name="departmentname" value="{{ old('departmentname') }}" required autocomplete="departmentname">

                                @error('departmentname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(Auth::user()->admins()->first()->faculty_id === 8)
                            <div class="row mb-3">
                                <label for="departmentcode" class="col-md-4 col-form-label text-md-end">Department Code</label>

                                <div class="col-md-6">
                                    <input id="departmentcode" type="departmentcode" class="form-control @error('departmentcode') is-invalid @enderror" name="departmentcode" value="{{ old('departmentcode') }}" required autocomplete="departmentname">

                                    @error('departmentcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <button onclick="history.back()" class="btn btn-primary">
                                    Close
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
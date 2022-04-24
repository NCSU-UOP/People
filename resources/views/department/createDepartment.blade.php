@extends('layouts.app')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a new Department</div>

                <div class="card-body">
                    <form method="POST" action="/dashboard/add/department" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="faculty_id" class="col-md-4 col-form-label text-md-end">Facutly name</label>
                            
                            <div class="col-md-6">
                                <select onchange="selectedFaculty(this)" id="faculty_id" type="faculty_id" class="form-select @error('faculty_id') is-invalid @enderror" name="faculty_id" value="{{ old('faculty_id') }}" required autocomplete="faculty_id">
                                    <option value="{{null}}">-- Select the Faculty --</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{$faculty['id']}}">{{$faculty['name']}}</option>
                                    @endforeach
                                </select>
                            
                                @error('faculty_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                          </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Department Name</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">Department Code</label>

                            <div class="col-md-6">
                                <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" disabled>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a type="button" class="btn btn-primary" href="/dashboard">
                                    Close
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function selectedFaculty(faculty) {
        var id = faculty.options[faculty.selectedIndex].value;        
        var departmentCode = document.getElementById("code");
        var AHSId = {!! $AHSId !!};
        
        if(id == null || id != AHSId) {
            departmentCode.disabled = true;
            departmentCode.value = null;
        } else {
            departmentCode.disabled = false;
        }
    }
</script>
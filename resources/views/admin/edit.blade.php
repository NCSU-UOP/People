@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <div class="container p-2 pb-2 rounded"><h1 class="font-weight-bold">Edit user details</h1></div>
        </div>
        <div class="card-body">
            <form action="/dashboard/{{$userData['id']}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Alex Steven Cooper" name="name" value="{{ old('name') ?? $userData['name']}}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>
                <div class="col-md-6">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $userData['username']}}" disabled>  
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                <div class="col-md-6">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $userData['email']}}" disabled>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="faculty_id" class="col-md-4 col-form-label text-md-end">Faculty name</label>

                <div class="col-md-6">
                    <select id="faculty_id" type="faculty_id" class="form-select @error('faculty_id') is-invalid @enderror" name="faculty_id" value="{{ old('faculty_id')}}">
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty['id']}}"
                                @if ($faculty['id'] == $userData['faculty_id'])
                                    selected
                                @endif
                            >{{$faculty['name']}}</option>
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
                <label for="active" class="col-md-4 col-form-label text-md-end">Type</label>
                
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_admin" id="flexRadioDefault1" value=1 @if($userData['isAdmin'] == 1) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Super admin
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_admin" id="flexRadioDefault2" value=0 @if($userData['isAdmin'] == 0) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Admin
                        </label>
                    </div>
                </div>
        
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
            
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Save</button>  
                    <a href="/dashboard" type="button" role="button" class="btn btn-secondary">Cancel</a>                    
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection
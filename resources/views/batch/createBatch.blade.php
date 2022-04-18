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
                <div class="card-header">Add a new Batch</div>

                <div class="card-body">
                    <form method="POST" action="/dashboard/add/batch" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="id" class="col-md-4 col-form-label text-md-end">ID</label>

                            <div class="col-md-6">
                                <input id="id" type="number" class="form-control @error('id') is-invalid @enderror" id="id" name="id" value="{{ old('id') }}" required autocomplete="id" autofocus>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="expire_date" class="col-md-4 col-form-label text-md-end">Expire Date</label>

                            <div class="col-md-6">
                                <input id="expire_date" type="date" min={{$minDate}} class="form-control @error('expire_date') is-invalid @enderror" name="expire_date" value={{ old('expire_date', $expireDate) }} required autocomplete="expire_date" autofocus>
                                
                                @error('expire_date')
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

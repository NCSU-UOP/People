
@extends('layouts.app')

@section('content')

<main class="container">
    <h1>{{$facName}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/dashboard/admin/unverifiedStudent/{{$facultyCode}}/{{$student['batch_id']}}">{{$student['batch_id']}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$student['initial']}}</li>
        </ol>
    </nav>
</main>

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="container pt-4">
   <div class="row gutters-sm "> 
       <div class="col-md-4 mb-3">
           <div class="card">
               <div class="card-body">
                   <div class="d-flex flex-column align-items-center text-center">
                        <img src={{$student['image']}} alt="{{"Profile Image: ".$student['preferedname']}}" style="border-radius: 10%" width="250">
                       <div class="mt-2">
                           <h4>{{$student['initial']}}</h4>
                       </div>
                       <div class="mt-2">
                           <h4>{{$student['regNo']}}</h4>
                       </div>
                   </div>
               </div>
           </div>
           <div class="mt-3">
               <div class="d-grid gap-2 col-6 mx-auto">
                <a href="{{URL::current()}}/verify" class="btn btn-primary" type="button">Verify</a>
                <a class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</a>
               </div>
           </div>
       </div>
       <div class="col-md-8">
           <div class="card mb-3">
               <div class="card-body">
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Prefered Name</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['preferedname']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Full Name</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['fullname']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Name with initial</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['initial']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">City</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['city']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Province</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['province']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Address</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$student['address']}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Faculty</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                       {{$facName}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Department</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                            {{$deptName}}
                       </div>
                   </div>
                   <hr>
                   <div class="row">
                       <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Username</span>
                       </div>
                       <div class="col-sm-9 text-secondary">
                        
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>


<!-- reject modal -->
<div class="modal fade" id="rejectModal" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Entry Rejection Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <p>Please indicate why are you rejecting the entry</p>
        <form action="{{URL::current()}}/reject" method="post" enctype="multipart/form-data">
            @csrf
            <div class="pt-1">
                <label for="keyerror" class="form-label">Key Error Type</label>
                <select id="keyerror" type="keyerror" class="form-select" name="keyerror">
                    <option value="Name Error">Name Error</option>
                    <option value="Wrong Picture">Wrong Picture</option>
                    <option value="User not found">User not found</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="pt-2">
                <label for="remarks" class="form-label">Remarks for user</label>
                <input type="text" class="form-control @error('remarks') is-invalid @enderror" placeholder="Some text here" name="remarks">
                @error('remarks')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- <button type="submit" class="btn btn-primary">Notify User</button> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Notify User</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Auth::user()->admins()->first()->is_admin === 1)
        @section('navbar-item')
            <a href="#" class="dropdown-item">Add new user</a>
            <a href="#" class="dropdown-item">Add/Edit faculty details</a>
            <a href="#" class="dropdown-item">Add/Edit batch details</a>
        @endsection

        <div class="p-3 pb-3 rounded">
            <h1 class="text-center font-weight-bold">Super-Admin Dashboard</h1>
        </div>

        <div class="container">
        <div class ="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Faculty</th>
                    <th scope="col">Active</th>
                    <th scope="col">Type(Admin/user)</th>
                    <th scope="col">Last Login</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach(json_decode($admin_list) as $admin)
                    @if($admin->admin === 1)
                        @php $is_admin = "Super admin"; @endphp
                    @elseif($admin->admin === 0)
                        @php $is_admin = "admin"; @endphp
                    @endif

                    @if($admin->valid === 1)
                        @php $active = "Yes"; @endphp
                    @elseif($admin->vaild === 0)
                        @php $active = "No"; @endphp
                    @endif

                    <tr>
                        <th scope="row">{{$admin->id}}</th>
                        <td>{{$admin->name}}</td>
                        <td>{{$admin->username}}</td>
                        <td>{{$admin->email}}</td>
                        <td>{{$admin->faculty}}</td>
                        <td>{{$active}}</td>
                        <td>{{$is_admin}}</td>
                        <td>{{$admin->online}}</td>
                        <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/delete/{{$admin->id}}">Remove</a></td>
                        <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit/{{$admin->id}}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>

    @else
        <div class="p-3 pb-3 rounded">
            <h1 class="text-center font-weight-bold">Admin Dashboard</h1>
        </div>
    @endif

@endsection
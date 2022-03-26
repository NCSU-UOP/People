
@extends('layouts.app')

@section('content')
<div class="p-3 pb-3 rounded">
            <h1 class="text-center font-weight-bold">Unverified Students List</h1>
        </div>

        <div class="container">
        <div class ="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Registration Number</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($studentList as $stdlist)
                    <tr>
                        <th scope="row">{{$stdlist['id']}}</th>
                        <td>{{$stdlist['regNo']}}</td>
                        <td>{{$stdlist['initial']}}</td>
                        <td><a type="button" class="btn btn-warning btn-sm" role="button" href="#">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>


@endsection
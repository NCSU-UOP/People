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
            <a href="/activity" class="dropdown-item">View site activity</a>
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

        @section('superAdminCharts')
        <div class="container">
        <div class="p-3 pb-3 rounded">
                <h2 class="text-center">Database Insights</h2>
            </div>
        <div class="p-5 pb-3 rounded">
                <h4 class="text-center">Total No of Students | Rejected | Verified | Unverified Students Vs Faculty Code</h4>
            </div>
        <!-- Chart's container -->
        <div id="chart" style="height: 300px;"></div>
        <!-- Charting library -->
        <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
        <!-- Chartisan -->
        <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
        <!-- Your application script -->
        <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('admin_chart1')",
            hooks: new ChartisanHooks()
                    .colors()
                    .legend()
                    .datasets(['bar','bar','bar','bar']),
        });
        </script>
        @endsection

    @elseif(Auth::user()->admins()->first()->is_admin === 0)
        <div class="p-3 pb-8 rounded">
            <h6 class="text-center text-muted">{{$facultyName}}</h6>
            <h1 class="text-center font-weight-bold">Admin Dashboard</h1>
            <div class="container pt-4 pb-4" style="display: flex; justify-content:center;">
                <div class="row" style="justify-content:center;">
                    @php $delay = 100;@endphp
                    @foreach($batches as $batch)
                        <div class="card bg-light m-1" data-aos="zoom-in" data-aos-delay={{$delay}}  style="max-width: 15rem;">
                            <div class="card-header text-center">{{$facultyCode}}/{{$batch['id']}}</div>
                            <img class="card-img-top" src="/img/staff.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h6 class="card-title text-center">Unverified Students</h6>
                                <h6 class="card-title text-center"><span class="badge bg-primary text-wrap">{{$count[$batch['id']]}}</span></h6>
                            </div>
                            <a href="dashboard/admin/unverifiedStudent/{{$facultyCode}}/{{$batch['id']}}" type="button" class="btn btn-outline-secondary btn-block mb-3">Explore</a>
                        </div>
                    @php $delay = $delay+100; @endphp
                    @endforeach
                </div>
            </div>
        </div>
        @section('AdminCharts')
        <div class="container">
        <div class="pt-3 rounded">
                <h2 class="text-center">Database Insights</h2>
            </div>
        <div class="p-5 pb-3 rounded">
                <h4 class="text-center">Total No of Students | Rejected | Verified | Unverified Students Vs Batch</h4>
                <h5 class="text-center">{{$facultyName}}</h5>
            </div>
        <!-- Chart's container -->
        <div id="chart2" style="height: 300px;"></div>
        <!-- Charting library -->
        <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
        <!-- Chartisan -->
        <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
        <!-- Your application script -->
        <script>
        const chart = new Chartisan({
            el: '#chart2',
            url: "@chart('admin_chart2')?facultycode={{$facultyCode}}",
            hooks: new ChartisanHooks()
                    .colors()
                    .legend()
                    .datasets(['bar','bar','bar','bar']),
        });
        </script>
        @endsection

    @else
        
    @endif

@endsection
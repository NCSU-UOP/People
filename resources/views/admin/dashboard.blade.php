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
            <a href="/dashboard/add/user" class="dropdown-item">Add new user</a>
            <a href="/dashboard/add/excelfile" class="dropdown-item">Add new excel file</a>
            <a href="/dashboard/add/faculty" class="dropdown-item">Add/Edit faculty details</a>
            <a href="/dashboard/add/batch" class="dropdown-item">Add/Edit batch details</a>
            <a href="/dashboard/add/department" class="dropdown-item">Add Department</a>
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
                        @else
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
                            <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit/{{$admin->id}}">Edit</a></td>
                            <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/delete/{{$admin->id}}">Remove</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="container">
            <div class="p-3 pb-3 rounded">
                <h2 class="text-center">Excel File Importation Details</h2>
            </div>
            @php $excelfilelist_array = json_decode($excelfile_list); @endphp
            @php echo(count($excelfilelist_array)) @endphp
            <div class ="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Usertype</th>
                        <th scope="col">Faculty</th>
                        <th scope="col">Batch</th>
                        <th scope="col">Uploaded by</th>
                        <th scope="col">link</th>
                        <th scope="col">Is_Imported</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @if(count($excelfilelist_array)>0)
                    <tbody>
                    @foreach($excelfilelist_array as $excelfile)
                        <tr>
                            <th scope="row">{{$excelfile->id}}</th>
                            <td>{{$excelfile->excel_filename}}</td>
                            <td>{{$excelfile->usertype}}</td>
                            <td>{{$excelfile->faculty}}</td>
                            <td>
                                @if($excelfile->batch_id == NULL)
                                    N/A
                                @elseif($excelfile->imported == 0)
                                    {{$excelfile->batch_id}}
                                @endif
                            </td>
                            <td>{{$excelfile->username}}</td>
                            <td>{{$excelfile->attributes}}</td>
                            <td>
                                @if($excelfile->imported == 1)
                                    <i class="bi bi-check-circle-fill" style="color:#48BB78;"></i>
                                @elseif($excelfile->imported == 0)
                                    <i class="bi bi-x-circle-fill" style="color:#ED8936;"></i>
                                @endif
                            </td>
                            <td><button type="button" class="btn btn-primary btn-sm" role="button" onclick="showPreview('{{$excelfile->excel_filename}}')">Preview</button></td>
                            @if($excelfile->imported == 1)
                                <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" href="/dashboard/edit/{{$admin->id}}" aria-disabled="true">Import</a></td>
                                <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit/{{$admin->id}}">RollBack</a></td>
                                <td><a type="button" class="btn btn-outline-danger btn-sm disabled" role="button" href="/dashboard/delete/{{$admin->id}}" aria-disabled="true">Remove</a></td>
                            @elseif($excelfile->imported == 0)
                                <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit/{{$admin->id}}">Import</a></td>
                                <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" href="/dashboard/edit/{{$admin->id}}" aria-disabled="true">RollBack</a></td>
                                <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/delete/{{$admin->id}}">Remove</a></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    @else
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center">No data found</td>
                            </tr>
                        </tbody>
                    @endif
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

    @else
        <main class="container">
        <h1>{{$facultyName}}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        </main>
        <div class="p-3 pb-8 rounded">
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
                            <a href="dashboard/student/{{$facultyCode}}/{{$batch['id']}}" type="button" class="btn btn-outline-secondary btn-block mb-3">Explore</a>
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
    @endif
@endsection


@section('admin-page-js')
<script src="/js/xlsx.full.min.js"></script>
@endsection


@section('admin-page-scripts')
@if(Auth::user()->admins()->first()->is_admin === 1)
@if(count($excelfilelist_array)>0)
<script>
    function showPreview(title) {
        var winPrint = window.open('', '', width=800,height=600,toolbar=0);
        winPrint.document.write('<html><head><title>Excel Preview</title><link href="{{ asset('css/app.css') }}" rel="stylesheet"></head><body><h1 style="text-align:center;" >Excel Preview</h1><h2 style="text-align:center;">{{$excelfile->excel_filename}}.xlsx</h2><div class="container-fluid" style="height: 75vh; width:  100vw;  overflow: auto;"><div class ="table-responsive"><table class ="table table-hover table-bordered table-striped table-dark" id="TableContainer" border="1"></table></div></div></body></html>');
        
		// winPrint.document.write('<head><title>Excel Preview</title></head><body><h1 style="text-align:center;" >Excel Preview</h1><h2 style="text-align:center;">{{$excelfile->excel_filename}}.xlsx</h2><div id="TableContainer" class ="table-responsive"></div></body>');
        (async() => {
        const f = await fetch("/uploads/excelfiles/"+title+".xlsx"); // replace with the URL of the file
        const ab = await f.arrayBuffer();

        /* Parse file and get first worksheet */
        const wb = XLSX.read(ab);
        const ws = wb.Sheets[wb.SheetNames[0]];

        /* Generate HTML */
        var output = winPrint.document.getElementById("TableContainer");
        output.innerHTML = XLSX.utils.sheet_to_html(ws);
        })();
    }
</script>
@endif
@endif
@endsection


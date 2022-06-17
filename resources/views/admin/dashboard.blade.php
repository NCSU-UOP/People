@extends('layouts.app')

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('Error') }}
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
                                    <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" aria-disabled="true">Imported</a></td>
                                    <!-- <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit">RollBack</a></td> -->
                                    <!-- <td><a type="button" class="btn btn-outline-danger btn-sm disabled" role="button" href="/dashboard/delete" aria-disabled="true">Remove</a></td> -->
                                @elseif($excelfile->imported == 0)
                                    <!-- <td><button type="button" class="btn btn-warning btn-sm" role="button" onclick="importExcel('{{$excelfile->id}}')">Import</button></td> -->
                                    <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/import/excelfile/{{$excelfile->id}}" onclick="javascript:importprogress(); return true;">Import</a></td>
                                    <!-- <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" href="/dashboard/edit" aria-disabled="true">RollBack</a></td> -->
                                    <!-- <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/delete">Remove</a></td> -->
                                @endif
                                <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/remove/excelfile/{{$excelfile->id}}">Remove</a></td>
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

            <!-- <div id="progressbar" style="margin: 20px;width: 400px;height: 8px;position: relative;"></div> -->
            <div id="importingAnimation"></div>

            @if(session()->has('failures'))
                <div class="p-3 pb-3 rounded">
                <h2 class="text-center bg-danger" style="color:white;">Some ERRORS have been found!</h2>
                </div>
                @php $failures = session()->get('failures'); @endphp
                @foreach($failures as $failure)
                    @php
                        $errors = json_encode($failure->errors());
                        $errors = str_replace('"', '', $errors);
                        $errors = str_replace('[', '', $errors);
                        $errors = str_replace(']', '', $errors);
                        $errors = str_replace('{', '', $errors);
                        $errors = str_replace('}', '', $errors);
                        $errors = str_replace('\\', '', $errors);
                        $values = json_encode($failure->values());
                        $values = str_replace('"', '', $values);
                        $values = str_replace('[', '', $values);
                        $values = str_replace(']', '', $values);
                        $values = str_replace('{', '', $values);
                        $values = str_replace('}', '', $values);
                        $values = str_replace('\\', '', $values);
                    @endphp
                    <div class="alert alert-danger" role="alert">
                    @if(strlen($failure->attribute())>0)
                    <h4 class="alert-heading">ERROR {{$failure->attribute()}} : {{$errors}}</h4>
                    @else
                    <h4 class="alert-heading">ERROR : {{$errors}}</h4>
                    @endif
                    <h3 class="alert-heading">@Row No:{{$failure->row()}}</h3>
                    @if(strlen($values)>0)
                    <hr>
                    <p class="mb-0">{{$values}}</p>
                    </div>
                    @else
                    <hr>
                    <p class="mb-0">We see that batch or faculty you entered doesn't match with the data in excel file. please check whether the excelfile is the correct one & try again. contact ncsu if you think you done it correctly!</p>
                    </div>
                    @endif   
                @endforeach
            @endif

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
        @section('navbar-item')
            <a href="/dashboard/add/excelfile" class="dropdown-item">Add new excel file</a>
        @endsection
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

        <div class="container">
            <div class="p-3 pb-3 rounded">
                <h2 class="text-center">Excel File Importation Details</h2>
            </div>
            @php $excelfilelist_array = json_decode($excelfile_list); @endphp
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
                        @if($excelfile->username == Auth::user()->username)
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
                                    <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" aria-disabled="true">Imported</a></td>
                                    <!-- <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/edit">RollBack</a></td> -->
                                    <!-- <td><a type="button" class="btn btn-outline-danger btn-sm disabled" role="button" href="/dashboard/delete" aria-disabled="true">Remove</a></td> -->
                                @elseif($excelfile->imported == 0)
                                    <td><a type="button" class="btn btn-warning btn-sm" role="button" href="/dashboard/import/excelfile/{{$excelfile->id}}" onclick="javascript:importprogress(); return true;">Import</a></td>
                                    <!-- <td><a type="button" class="btn btn-outline-secondary btn-sm disabled" role="button" href="/dashboard/edit" aria-disabled="true">RollBack</a></td> -->
                                    <!-- <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/delete">Remove</a></td> -->
                                @endif
                                <td><a type="button" class="btn btn-danger btn-sm" role="button" href="/dashboard/remove/excelfile/{{$excelfile->id}}">Remove</a></td>
                            </tr>
                        @endif
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

            <div id="importingAnimation"></div>

            @if(session()->has('failures'))
                <div class="p-3 pb-3 rounded">
                <h2 class="text-center bg-danger" style="color:white;">Some ERRORS have been found!</h2>
                </div>
                @php $failures = session()->get('failures'); @endphp
                @foreach($failures as $failure)
                    @php
                        $errors = json_encode($failure->errors());
                        $errors = str_replace('"', '', $errors);
                        $errors = str_replace('[', '', $errors);
                        $errors = str_replace(']', '', $errors);
                        $errors = str_replace('{', '', $errors);
                        $errors = str_replace('}', '', $errors);
                        $errors = str_replace('\\', '', $errors);
                        $values = json_encode($failure->values());
                        $values = str_replace('"', '', $values);
                        $values = str_replace('[', '', $values);
                        $values = str_replace(']', '', $values);
                        $values = str_replace('{', '', $values);
                        $values = str_replace('}', '', $values);
                        $values = str_replace('\\', '', $values);
                    @endphp
                    <div class="alert alert-danger" role="alert">
                    @if(strlen($failure->attribute())>0)
                    <h4 class="alert-heading">ERROR {{$failure->attribute()}} : {{$errors}}</h4>
                    @else
                    <h4 class="alert-heading">ERROR : {{$errors}}</h4>
                    @endif
                    <h3 class="alert-heading">@Row No:{{$failure->row()}}</h3>
                    @if(strlen($values)>0)
                    <hr>
                    <p class="mb-0">{{$values}}</p>
                    </div>
                    @else
                    <hr>
                    <p class="mb-0">We see that batch or faculty you entered doesn't match with the data in excel file. please check whether the excelfile is the correct one & try again. contact ncsu if you think you done it correctly!</p>
                    </div>
                    @endif   
                @endforeach
            @endif

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

    <!-- Modal -->
    <div class="modal fade" id="importmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title fw-bold text-danger w-100"><<< DO NOT CLOSE THIS TAB >>></h5>
            </div>
            <div class="modal-body">
                <div class="container pt-5">
                    <div class="wrapper pt-5">
                        <div class="circle"></div>
                        <div class="circle"></div>
                        <div class="circle"></div>
                        <div class="shadow"></div>
                        <div class="shadow"></div>
                        <div class="shadow"></div>
                        <div id="import">
                            <div>G</div>
                            <div>N</div>
                            <div>I</div>
                            <div>T</div>
                            <div>R</div>
                            <div>O</div>
                            <div>P</div>
                            <div>M</div>
                            <div>I</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <p class="font-monospace text-secondary w-100">Be patient! This process may take a while to finish</p>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('admin-page-js')
<script src="/js/xlsx.full.min.js"></script>
@endsection

@section('admin-page-css')
<link href="{{ asset('css/importloader.css') }}" rel="stylesheet">
@endsection


@section('admin-page-scripts')
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
@endsection

@section('admin-page-scripts2')
<script>
var current_row = 0;
var total_rows = 0;
var progress = 0;
var count = 0;

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

// function importExcel(id){
//     $.ajax({
//         url: '/dashboard/import/excelfile/' + id,
//         type: "GET",
//         async: true,
//         success:function(data) {
//             console.log('success1');
//             document.location.reload(true);
//         },
//         error:function(data) {
//             console.log('error1');
//         },
//         complete:function(data){
//             console.log('hi');
//         },
//     });
// }

function getStatus(id) {
    sleep(1000);
    console.log('/import-status/' + id);
    count = count + 1;
    $.ajax({
        url: '/import-status/' + id,
        type: "GET",
        dataType: "json",
        async: false,
        cashe: false,
        success:function(data) {
            // console.log(data);
            if(data)
            {
                console.log(data);
                
                if (data.finished) {
                console.log('fuck2');
                current_row = total_rows;
                progress = 1;
                document.location.reload(true);
                return;
                };

                total_rows = data.total_rows;
                current_row = data.current_row;
                progress = Math.ceil(data.current_row / data.total_rows);
                console.log(progress);
                sleep(10);
            }
            else
            {
                $('#progressbar').empty();
                console.log('fuck');
            }
        },
        error:function(data) {
            console.log('error');
        },
        complete:function(){
            console.log('complete');
            if(count<30){
                console.log(count);
                getStatus(id);}
            // sleep(100000);
            // getStatus(id);
        }
    });
}

function importprogress(){
    // document.getElementById('importingAnimation').innerHTML = '<div class="container"><div class="wrapper"><div class="circle"></div><div class="circle"></div><div class="circle"></div><div class="shadow"></div><div class="shadow"></div><div class="shadow"></div><div id="load"><div>G</div><div>N</div><div>I</div><div>T</div><div>R</div><div>O</div><div>P</div><div>M</div><div>I</div></div></div></div>';
    // return true;
    $('#importmodal').modal('show');
    return true;
}
</script>

@endsection


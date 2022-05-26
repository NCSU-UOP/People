@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Excel File</div>

                <div class="card-body">
                    <form method="POST" action="/dashboard/add/excelfile" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="usertype" class="col-md-4 col-form-label text-md-end">Usertype</label>

                            <div class="col-md-6">
                                <select id="usertype" type="usertype" class="form-select form-control @error('usertype') is-invalid @enderror" name="usertype" value="{{ old('usertype') }}" required autocomplete="usertype">
                                    @foreach($usertype as $data)
                                        <option value="{{$data[0]}}">{{$data[1]}}</option>
                                    @endforeach
                                </select>

                                @error('usertype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="faculty_id" class="col-md-4 col-form-label text-md-end">Facutly name</label>

                            @if(Auth::user()->admins()->first()->is_admin === 1)
                            <div class="col-md-6">
                                <select id="faculty_id" type="faculty_id" class="form-select form-control @error('faculty_id') is-invalid @enderror" name="faculty_id" value="{{ old('faculty_id') }}" required autocomplete="faculty_id">
                                    @foreach($faculty as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>

                                @error('faculty_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @else
                            @foreach($faculty as $data)
                                @if($data->id === Auth::user()->admins()->first()->faculty_id)
                                    @php $faculty_name = $data->name; @endphp
                                @endif
                            @endforeach
                            <div class="col-md-6">
                                <input id="facultyid" type="facultyid" class="form-control" name="facultyid" placeholder="{{ $faculty_name }}" disabled>
                                <input id="faculty_id" type="hidden" class="form-control @error('faculty_id') is-invalid @enderror" name="faculty_id" value="{{ Auth::user()->admins()->first()->faculty_id }}">
                                @error('faculty_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @endif
                            </div>

                        <div class="row mb-3">
                            <label for="batch_id" class="col-md-4 col-form-label text-md-end">Batch</label>

                            <div class="col-md-6">
                                <select id="batch_id" type="batch_id" class="form-select form-control @error('batch_id') is-invalid @enderror" name="batch_id" value="{{ old('batch_id') }}" required autocomplete="batch_id">
                                    @foreach($batch as $data)
                                        <option value="{{$data->id}}">{{$data->id}}</option>
                                    @endforeach
                                </select>

                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Type</label>
                            
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_admin" id="flexRadioDefault1" value=1>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Super admin
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_admin" id="flexRadioDefault2" value=0 checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Admin
                                    </label>
                                </div>
                            </div>
                    
                        </div> -->

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Attributes in Excel</label>    
                            <div class="col-md-6">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="excelAttributes[]" value="fullname" id="flexCheckfullname">
                                <label class="form-check-label" for="flexCheckDefault">
                                    fullname
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="excelAttributes[]" value="initial" id="flexCheckinitial">
                                <label class="form-check-label" for="flexCheckChecked">
                                    initial
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="excelAttributes[]" value="address" id="flexCheckaddress">
                                <label class="form-check-label" for="flexCheckChecked">
                                    address
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="excelAttributes[]" value="email" id="flexCheckemail">
                                <label class="form-check-label" for="flexCheckChecked">
                                    email
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="excelAttributes[]" value="telephone" id="flexChecktelephone">
                                <label class="form-check-label" for="flexCheckChecked">
                                    telephone
                                </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="excel_file" class="col-md-4 col-form-label text-md-end">Select Excel file</label>

                            <div class="col-md-6">
                                <!-- <select id="batch_id" type="batch_id" class="form-select form-control @error('batch_id') is-invalid @enderror" name="batch_id" value="{{ old('batch_id') }}" required autocomplete="batch_id">
                                    @foreach($batch as $data)
                                        <option value="{{$data->id}}">{{$data->id}}</option>
                                    @endforeach
                                </select> -->

                                <input type="file" id="excel_file" class="@error('excel_file') is-invalid @enderror" name="excel_file"/>

                                @error('excel_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                                <a href="/dashboard" class="btn btn-primary">
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
<div id="excel_data" class="mt-5"></div>
@endsection

@section('excelupload-page-js')
<script src="/js/xlsx.full.min.js"></script>
@endsection

@section('excel-preview-script')
<script>
    $(document).ready(function(){
        $('#excel_file').change(function(){
            var excel_file = $('#excel_file').val();
            var extension = excel_file.split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['xlsx']) == -1)
            {
                alert("Invalid File. Only xlsx is supported");
                $('#excel_file').val('');
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.readAsArrayBuffer(event.target.files[0]);
                reader.onload = function(event){
                    var data = new Uint8Array(reader.result);
                    var work_book = XLSX.read(data, {type:'array'});
                    var sheet_name = work_book.SheetNames;
                    // console.log(sheet_name);
                    if(sheet_name.length > 1){
                        alert("File contains more than 1 sheet. Only 1 sheet is supported");
                        $('#excel_file').val('');
                        return false;
                    }
                    else{
                        var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});
                        if(sheet_data.length > 0)
                        {
                            var table_output = '<h1 style="text-align:center;" >Excel Preview</h1><div class="container-fluid" style="height: 75vh; width:  100vw;  overflow: auto;"><div class ="table-responsive"><table class="table table-striped table-hover table-bordered table-dark">';
                            for(var row = 0; row < sheet_data.length; row++)
                            {
                                table_output += '<tr>';
                                for(var cell = 0; cell < sheet_data[row].length; cell++)
                                {
                                    if(row == 0)
                                    {
                                        table_output += '<th>'+sheet_data[row][cell]+'</th>';
                                    }
                                    else
                                    {
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }
                                table_output += '</tr>';
                            }
                            table_output += '</table></div></div>';
                            document.getElementById("excel_data").innerHTML = table_output;
                            // console.log(table_output);
                        }
                        excel_file.value = '';
                    }
                }
            }
        });
    });
</script>
@endsection
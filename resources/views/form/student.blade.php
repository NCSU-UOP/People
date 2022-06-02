@extends('layouts.app')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-{{session()->get('color')}} alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container p-2 pb-2 rounded" data-aos="zoom-in" data-aos-delay=100>
            <h1 class="text-center font-weight-bold">Data Collection Form</h1>
</div>

<div class="container" data-aos="zoom-in" data-aos-delay=100>
  <form id="data_form" class="row g-3" method="POST" action="/form/student" enctype="multipart/form-data">
    @csrf

    <div class="col-md-6">
      <label for="fullname" class="form-label">Full name</label>

      <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" placeholder="Alex Steven Cooper" name="fullname" value="{{ old('fullname') }}" required autocomplete="fullname" autofocus>

      @error('fullname')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-6">
      <label for="preferedname" class="form-label">Prefered name</label>

      <input id="preferedname" type="text" class="form-control @error('preferedname') is-invalid @enderror" placeholder="Alex Cooper" name="preferedname" value="{{ old('preferedname') }}" required autocomplete="preferedname" autofocus>

      @error('preferedname')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>
    
    <div class="col-md-6">
      <label for="initial" class="form-label">Name with initial</label>

      <input id="initial" type="text" class="form-control @error('initial') is-invalid @enderror" placeholder="A.S. Cooper" name="initial" value="{{ old('initial') }}" required autocomplete="initial" autofocus>

      @error('initial')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-6">
      <label for="username" class="form-label">Username</label>
      
      <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Cooper360" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

      @error('username')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-12">
      <label for="address" class="form-label">Address</label>
      
      <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" placeholder="1234 Main St, Sanfrancisco, California" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

      @error('address')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>
    
    <div class="col-md-6">
      <label for="city" class="form-label">City</label>
      
      <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" placeholder="California" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>

      @error('city')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-6">
      <label for="province" class="form-label">Province</label>
      
      <select id="province" type="province" class="form-select @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}" required autocomplete="province">
        <option value="{{null}}">-- Select the Province --</option>
        @foreach ($provinces as $province)
            <option value="{{$province}}">{{$province}}</option>
        @endforeach
      </select>

      @error('province')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-6">
      <label for="faculty_id" class="form-label">Facutly name</label>

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

    <div class="col-md-4">
      <label for="department_id" class="form-label">Department name</label>

      <select onchange="selectedDepartment()" id="department_id" type="department_id" class="form-select @error('department_id') is-invalid @enderror" name="department_id" value="{{ old('department_id') }}" required autocomplete="department_id">
        <option value="{{null}}">-- Select the Department --</option>
      </select>

      @error('department_id')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>

    <div class="col-md-2">
      <label for="batch_id" class="form-label">Batch</label>

      <select onchange="selectedBatch()" id="batch_id" type="batch_id" class="form-select @error('batch_id') is-invalid @enderror" name="batch_id" value="{{ old('batch_id') }}" required autocomplete="batch_id">
        <option value="{{null}}">-- Select --</option>
        @foreach ($batches as $batch)
            <option value="{{$batch['id']}}">{{$batch['id']}}</option>
        @endforeach
      </select>

      @error('batch_id')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-10">
      <label for="email" class="form-label">Email</label>
      
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your Gsuite email address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

      @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror

    </div>

    <div class="col-md-2">
      <label for="regNo" class="form-label">Reg no.</label>
      
      <div class="input-group mb-3">
        <span class="input-group-text" id="regNoFiller">X/XX/</span>
        <input id="regNo" type="string" class="form-control @error('regNo') is-invalid @enderror" placeholder="500" name="regNo" value="{{ explode('/', old('regNo'))[count(explode('/', old('regNo')))-1] }}" required autocomplete="regNo" autofocus>
        @error('regNo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>

      
    </div>

    <div class="mb-3">
      <label for="formFile" class="form-label">Insert a Profile Image</label>
      <input class="form-control" type="file" id="formFile" name="image" required>  
    </div>

    <div class="col-12">
      <p>Above details are true to the best of my knowledge and belief
        and I understand that I subject myself to disciplinary action in the event that
        the above facts are found to be falsified. 
      </p>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>

  
  @endsection

@section('footer')
  <div class="block">
    <div class="container" >
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">© 2022 University of Peradeniya</p>

        <ul class="nav col-md-4 justify-content-end">
          <p>All rights reserved</p>
        </ul>

      </footer>
    </div>
  </div>
@endsection


<script>
  function selectedFaculty(faculty) {
    var id = faculty.options[faculty.selectedIndex].value;    
    var departmentSelector = document.getElementById("department_id");
    var departments = {!! $departments !!};

    // Clear previous options
    departmentSelector.innerText = null;

    // Append user prompt with a null key
    var opt = document.createElement('option');
    opt.value = null;
    opt.innerHTML = "-- Select the Department --";
    departmentSelector.appendChild(opt);

    // Append all the departments
    if (id) {
      departments[id].forEach(department => {
        var opt = document.createElement('option');
        opt.value = department['id'];
        opt.innerHTML = department['name'];
        departmentSelector.appendChild(opt);
      });
    }

    setBatchFiller();
  }

  // Update Reg No filler when the department is updated
  function selectedDepartment() {
    setBatchFiller();
  }

  // Update Reg No filler when the batch is updated
  function selectedBatch() {
    setBatchFiller();
  }

  // Update Reg No filler
  function setBatchFiller() {
    var batchID = document.getElementById("batch_id").value;
    var departmentIndex = document.getElementById("department_id").selectedIndex;
    var facultyIndex = document.getElementById("faculty_id").selectedIndex;
    var filler = document.getElementById("regNoFiller");
    var fcodeList = {!! $fcodes !!};
    var dcodeList = {!! $dcodes !!};

    // To adopt the registration number of management faculty
    var depCodeForManagement = "";
    if(facultyIndex != 0) {
      if(fcodeList[facultyIndex-1]['code'] == "AHS") {
        if(departmentIndex != 0)
          depCodeForManagement += dcodeList[departmentIndex-1]['code'] + '/';
        else
        depCodeForManagement += 'XXX/';
      }
    }
    

    if(facultyIndex != 0 && batchID) {
      filler.innerText = fcodeList[facultyIndex-1]['code'] + "/" + batchID + "/" + depCodeForManagement;      
    } else if (facultyIndex != 0 && !batchID){
      filler.innerText = fcodeList[facultyIndex-1]['code'] + "/XX/" + depCodeForManagement;
    } else if (facultyIndex  == 0 && batchID) {
      filler.innerText = "X/" + batchID + "/" + depCodeForManagement;
    } else {
      filler.innerText = "X/XX/" + depCodeForManagement;
    }
  }
</script>
@extends('layouts.app')

@section('content')
<!-- -------------------------- Bio Modal ------------------------------------- -->
<div class="modal fade" id="biostaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Bio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/bio/{{$student['username']}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control @error('bio') is-invalid @enderror" rows="10" aria-label="bio textarea" id="bio" name="bio" maxlength="200">{{ old('bio') ?? $student['bio']}}</textarea>
            @error('bio')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>    
        </form>
      </div>
    </div>
  </div>
</div>
<!-- -------------------------------------------------------------------------- -->

<!-- -------------------------- Social Media Modal ------------------------------------- -->
<div class="modal fade" id="socialstaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Social Media</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/socialmedia/{{$student['username']}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="cv" class="col-sm-2 col-form-label">CV</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('cv') is-invalid @enderror" class="form-control" id="cv" name="cv" maxlength="200">
                @error('cv')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="website" class="col-sm-2 col-form-label">Personel Website</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('website') is-invalid @enderror" class="form-control" id="website" name="website" maxlength="200">
                @error('website')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('facebook') is-invalid @enderror" class="form-control" id="facebook" name="facebook" maxlength="200">
                @error('facebook')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div> 

            <div class="row mb-3">
                <label for="linkedin" class="col-sm-2 col-form-label">LinkedIn</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('linkedin') is-invalid @enderror" class="form-control" id="linkedin" name="linkedin" maxlength="200">
                @error('linkedin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('twitter') is-invalid @enderror" class="form-control" id="twitter" name="twitter" maxlength="200">
                @error('twitter')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('instagram') is-invalid @enderror" class="form-control" id="instagram" name="instagram" maxlength="200">
                @error('instagram')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="discord" class="col-sm-2 col-form-label">Discord</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('discord') is-invalid @enderror" class="form-control" id="discord" name="discord" maxlength="200">
                @error('discord')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="medium" class="col-sm-2 col-form-label">Medium</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('medium') is-invalid @enderror" class="form-control" id="medium" name="medium" maxlength="200">
                @error('medium')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div> 
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ----------------------------------------------------------------------------------- -->

<!-- -------------------------- Contact details model ---------------------------------- -->
<div class="modal fade" id="contactstaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Contact details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/contacts/{{$student['username']}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="687/3, Nagolla, Kegalle" value="{{$student['address']}}">
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="city" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-10">
                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="Kegalle" value="{{$student['city']}}">
                @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div> 

            <div class="row mb-3">
                <label for="province" class="col-sm-2 col-form-label">Province</label>
                <div class="col-sm-10">
                    <select id="province" type="province" class="form-select @error('province') is-invalid @enderror" name="province">
                        <option value="{{null}}">-- Select the Province --</option>
                        @foreach ($provinces as $province)
                            <option value="{{$province}}"
                                @if ($province == $student['province'])
                                    selected="selected"
                                @endif
                            >{{$province}}</option>
                        @endforeach
                    </select>

                    @error('province')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="telephone" class="col-sm-2 col-form-label">Telephone No.</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('telephone') is-invalid @enderror" class="form-control" id="telephone" name="telephone" placeholder="0771234567" value="{{$student['telephone']}}">
                @error('telephone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div> 
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ----------------------------------------------------------------------------------- -->


<!-- ------------------------ Profile view --------------------------------------------- -->
<div class="container">
    <div class="bg-primary p-3 pb-1 rounded" style="--bs-bg-opacity: .1;">
        <h1>Student Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/people">People</a></li>
                <li class="breadcrumb-item"><a href="/people/student">Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$student['facultyName']}} / {{$student['batch_id']}} / {{$student['username']}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pt-4">
    <div class="row gutters-sm ">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{$student['image']}}" alt="image" style="border-radius: 10%" width="200">
                        <div class="mt-2"><h4>{{$student['preferedname']}}</h4></div>
                        <h5 class="text-muted"> {{"@".$student['username']}}</h5>
                    </div>
                    <div class="d-flex flex-column border border-3 mt-3 p-3">
                        <div class="container p-0">
                            <div class="float-start"><h4> Bio </h4></div>
                            @auth
                                @if (Auth::user()->username == $student['username'] && $student['is_verified'])
                                    <div class="float-end"><a type="button" data-bs-toggle="modal" data-bs-target="#biostaticBackdrop" style="text-decoration: none; color:blue;"><i class="bi bi-pencil-square"></i> edit</a></div>
                                @endif
                            @endauth
                        </div>
                        <p>{{$student['bio']}}</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <div class="float-start" style="font-weight: 1000"><i class="bi bi-lightning-fill"></i>  Social Media</div>
                    @auth
                        @if (Auth::user()->username == $student['username'] && $student['is_verified'])
                            <div class="float-end"><a type="button" data-bs-toggle="modal" data-bs-target="#socialstaticBackdrop" style="text-decoration: none; color:blue;"><i class="bi bi-pencil-square"></i> edit</a></div>
                        @endif
                    @endauth
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($student['socialmedia'] as $social)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                        @if ($social['media_name'] == 'cv')
                            <i class="bi bi-file-person"></i>
                        @elseif ($social['media_name'] == 'website')
                            <i class="bi bi-globe"></i>
                        @else
                            <i class="bi bi-{{$social['media_name']}}"></i>
                        @endif
                        {{$social['media_name']}}</h6>
                        <span class="text-secondary"> <a href="{{$social['media_link']}}" target="_blank"><button type="button" class="btn btn-outline-secondary btn-sm">View</button></a></span>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="col-md-8">
            @auth
            @if (Auth::user()->admins()->first() != null )
                @php $admin = true @endphp
                @if(Auth::user()->admins()->first()->is_admin === 1)
                    @php $super_admin = true; 
                        $fac_id = Auth::user()->admins()->first()->faculty_id; @endphp
                @elseif(Auth::user()->admins()->first()->is_admin === 0)
                    @php $super_admin = false; 
                        $fac_id = Auth::user()->admins()->first()->faculty_id; @endphp
                @endif
            @else
                @php $admin = false @endphp
                @php $super_admin = false; @endphp
                @php $fac_id = null; @endphp
            @endif
            @if ($admin && ($super_admin || $fac_id === $student['facultyID']))
            <div class="card">
                <div class="card-header">
                    <div class="float-start" style="font-weight: 1000"><i class="bi bi-eye-fill"></i> Account Visibility</div>
                            <div class="form-check form-switch float-end">
                            <label class="form-check-label text-wrap badge" style="width: 4rem;" for="flexSwitchCheck" id="flexSwitchChecklabel"></label>
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheck">
                            </div>
                </div>
            </div>
            @endif
            @endauth
            <div class="card mb-3">
                <div class="card-header">
                    <div class="float-start" style="font-weight: 1000"><i class="bi bi-person-fill"></i> Profile</div>
                    @if ($student['is_verified'])
                        <div class="float-end badge bg-success text-wrap" style="width: 5rem;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Information on this palette is verified by a faculty official on {{$student['date']}}">verified <i class="bi bi-check-circle-fill"></i></div>
                    @else
                        <div class="float-end badge bg-warning text-wrap" style="width: 5rem; color:black" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Information on this palette is not verified by a faculty official yet">unverified <i class="bi bi-x-circle-fill"></i></div>
                    @endif
                </div>
                
                <div class="card-body">
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
                            <span class="mb-0" style="font-weight: 500">Faculty</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$student['facultyName']}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Registration Number</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$student['regNo']}}
                        </div>
                    </div>
                </div>    
            </div>

            <div class="card mb-3 pt-2">
                <div class="card-header">
                    <div class="float-start" style="font-weight: 1000"><i class="bi bi-person-lines-fill"></i> Additional Details</div>
                    @auth
                        @if (Auth::user()->username == $student['username'] && $student['is_verified'])
                            <div class="float-end"><a type="button" data-bs-toggle="modal" data-bs-target="#contactstaticBackdrop" style="text-decoration: none; color:blue;"><i class="bi bi-pencil-square"></i> edit</a></div>
                        @endif
                    @endauth
                </div>
            <div class="card-body">
                <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Name with Initials</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$student['initial']}}
                        </div>
                </div>
                <hr>
                <div class="row">
                        <div class="col-sm-3">
                            <span class="mb-0" style="font-weight: 500">Department</span>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$student['departmentName']}}
                        </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Email</span>
                    </div>
                    <div class="col-sm-9 text-secondary">{{$student['email']}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Address</span>
                    </div>
                    <div class="col-sm-9 text-secondary">{{$student['address']}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">City</span>
                    </div>
                    <div class="col-sm-9 text-secondary">{{$student['city']}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Province</span>
                    </div>
                    <div class="col-sm-9 text-secondary">{{$student['province']}}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="mb-0" style="font-weight: 500">Telephone No.</span>
                    </div>
                    <div class="col-sm-9 text-secondary">{{$student['telephone']}}</div>
                </div>
            </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('profile-page-scripts')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@auth
@if ($admin && ($super_admin || $fac_id === $student['facultyID']))
<script>
    /**
     * Script to change visibility state in database
     */
    $(function() {
        $('#flexSwitchCheck').change(function() {
            let makeVisible = Number($(this).prop('checked'));
            // console.log(makeVisible);
            $.ajax({
                url: '/changeVisibility',
                type: "PUT",
                data : {"_token":"{{ csrf_token() }}", "visibilityStatus":makeVisible, "username":"{{$student['username']}}"},
                success:function(data) {
                    console.log(data);
                    document.location.reload(true);
                    }
            });
        })
    });
</script>

<script>
    /**
     * Script to adjust toggle state depending on the database data
     */
    window.addEventListener("load", function() {
        if({{$student['visibility']}} == 1) {
            // console.log("hello");
            document.getElementById("flexSwitchCheck").checked = true;
            $('#flexSwitchChecklabel').html('Visible ');
            // console.log($('flexSwitchChecklabel').classList);
            document.getElementById("flexSwitchChecklabel").classList.add('bg-primary');
            document.getElementById("flexSwitchChecklabel").innerHTML += '<i class="bi bi-eye-fill" aria-hidden="true"></i>';
            
            

        } 
        else{
            document.getElementById("flexSwitchCheck").checked = false;
            $('#flexSwitchChecklabel').html('Hidden ');
            document.getElementById("flexSwitchChecklabel").classList.add('bg-danger');
            document.getElementById("flexSwitchChecklabel").innerHTML += '<i class="bi bi-eye-slash-fill" aria-hidden="true"></i>';

        }
    });
</script>
@endif
@endauth

@endsection

@section('profile-page-js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
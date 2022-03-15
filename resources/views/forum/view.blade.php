@extends('layouts.app')

@section('content')
<div class="container p-2 pb-4 rounded">
    <h1 class="text-center font-weight-bold">Forum Selection</h1>
</div>

<div class="container" style="display: flex; justify-content:center;">
    <div class="row">
    <div class="col-sm-6" style="justify-content: center;">
        <div class="card bg-light mb-3" style="max-width: 18rem;">
            <div class="card-header text-center">Academic Staff</div>
            <img class="card-img-top" src="/img/staff.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Academic Staff forum</h5>
                <p class="card-text">Academic staff should fill this forum to create an account</p>
                <a href="/forum/staff" class="btn btn-primary">Visit</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card bg-light mb-3" style="max-width: 18rem;">
            <div class="card-header text-center">Students</div>
            <img class="card-img-top" src="/img/student.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Student forum</h5>
                <p class="card-text">Students should fill this forum to create and account</p>
                <a href="/forum/student" class="btn btn-primary">Visit</a>
            </div>
        </div>
    </div>
    </div>
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
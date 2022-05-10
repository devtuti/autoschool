@extends('layouts.studentregister')
@section('title')
    Register page
@endsection
@section('css')
@endsection

@section('content')
<body class="hold-transition register-page">
<div class="register-box">
@if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="fas fa-close"></i>
                    </button>
                    <span>
                      <b> Owibka - </b> {{$error}}</span>
                  </div>
                  @endforeach
                @endif
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{route('home')}}" class="h1"><b>Code</b>Moves</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{route('student_register')}}" method="post">
          @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <select name="teacher" class="form-control">
                <option value="">Choose teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{$teacher->id}}">{{$teacher->name_familya}}</option>
                @endforeach
            </select>
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-users"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="{{route('studentlogin')}}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
@endsection



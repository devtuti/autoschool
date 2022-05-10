
@extends('layouts.front')
@section('title')
     Edit profile
@endsection
@section('css')
@endsection

@section('content')
<!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit profile</h4>
                  <p class="card-category"></p>
                </div>
              <div class="card-body">
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Owibka - </b> {{$error}}</span>
                  </div>
                  @endforeach
                @endif
                  
                      <form action="{{route('post.edit.profile', $users->id)}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Name</label>
                            <input type="text" class="form-control" name="username" value="{{$users->name}}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="email" value="{{$users->email}}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Password</label>
                            <input type="password" class="form-control" name="pass" value="{{$users->password}}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Photo</label>
                            <input type="file" class="form-control" name="photo" value="{{$users->photo}}">
                            <br><img src="{{asset('users/'.$users->photo)}}" width="100px" height="100px">
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary pull-right">Edit profile</button>
                      <div class="clearfix"></div>
                      </form>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
       
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')

@endsection

@extends('layouts.front')
@section('title')
     Mesaj to Users
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
                  <h4 class="card-title">Mesaj yazin..</h4>
                  <p class="card-category"></p>
                </div>
              <div class="card-body">
                @foreach($users as $user)
                    <a href="{{route('sms.user')}}/{{$user->id}}" class="card-link">{{$user->name}}</a>
                @endforeach
                @foreach($admins as $admin)
                    <a href="{{route('sms.user')}}/{{$admin->id}}" class="card-link">{{$admin->name_familya}}</a> 
                @endforeach
                 <br>
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
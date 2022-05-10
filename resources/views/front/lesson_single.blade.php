@extends('layouts.front')
@section('title')
    Lesson single page
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
              <div class="card-body">
                <h5 class="card-title">{{$lesson->lesson_name}}</h5><br>
                <img src="{{asset('lessons/'.$lesson->photo)}}" width="300px" min-height="300px"/><br>
                <p class="card-text">
                 {{$lesson->content_text}} 
                </p>

                
                <a href="{{route('tests')}}/{{$lesson->cat_id}}" class="card-link">Tests</a>
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

 

 

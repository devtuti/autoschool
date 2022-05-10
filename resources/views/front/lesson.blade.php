@extends('layouts.front')
@section('title')
    Lesson page
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
          @foreach($lessons as $lesson)
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$lesson->lesson_name}}</h5><br>
                <img src="{{asset('lessons/'.$lesson->photo)}}" width="300px" min-height="300px"/><br>
                <p class="card-text">
                  {{Str::limit($lesson->content_text, 50)}}
                </p>

                <a href="{{route('single_lesson')}}/{{$lesson->l_slug}}" class="card-link">More</a>
                <a href="{{route('tests')}}/{{$lesson->cat_id}}" class="card-link">Tests</a>
              </div>
            </div>

            
          </div>
          <!-- /.col-md-6 -->
       
        </div>
        @endforeach
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

@section('js')
@endsection

 

 

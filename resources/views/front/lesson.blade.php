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
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!--<h1></h1>-->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">

    @foreach($lessons as $lesson)
    <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">{{$lesson->lesson_name}}</h3>
              <div class="col-12">
              @if(!empty($lesson->photo))
                <img src="{{asset('lessons/'.$lesson->photo)}}" class="product-image" alt="">
              @endif
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <h3 class="my-3">{{$lesson->lesson_name}}</h3>
              <p>{{Str::limit($lesson->content_text, 50)}}</p>
              <a href="{{route('single_lesson')}}/{{$lesson->l_slug}}" class="card-link">More</a>
              <a href="{{route('tests')}}/{{$lesson->cat_id}}" class="card-link">Tests</a>
            </div>
          </div>
        </div>
    </div>
    @endforeach

    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

@section('js')
@endsection

 

 

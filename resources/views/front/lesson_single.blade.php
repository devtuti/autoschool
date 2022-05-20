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
              <p>{{$lesson->content_text}}</p>
              <a href="{{route('tests')}}/{{$lesson->cat_id}}" class="card-link">Tests</a>
            </div>
          </div>
        </div>
    </div>

    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

@section('js')
@endsection

 

 

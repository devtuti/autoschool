@extends('layouts.front')
@section('title')
    Course page
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

    @foreach($courses as $course)
        
        <div class="card card-solid">
            <div class="card-body">
            @foreach($user_kurs as $user_k)
            @if(count($user_kurs)>0)
            
                @if($course->id==$user_k->kurs_id and $user_k->user_id==Auth::user()->id)
                    <div class="callout callout-success ">
                @else
                    <div class="callout callout-danger">
                @endif
             @else
                <div class="callout callout-danger">
                
            @endif
            @endforeach
                    <h5>Course name: {{$course->kurs_name}}</h5>
                    <h3 class="my-3">Course price: {{$course->price}} azn</h3>
                    <h3 class="my-3">Course discount: {{$course->discount}}%</h3>
                    <p> Course content: {{$course->kurs_content}}</p>
                    <h6>Teacher name: {{$course->name_familya}}</h6>
                    <h6><i>Course share date: {{$course->k_date}}</i></h6>
                    @foreach($user_kurs as $user_k)
                        @if(count($user_kurs)>0)
                            @if($course->id==$user_k->kurs_id and $user_k->user_id==Auth::user()->id)
                            @else
                                <a href="" class="card-link">Satin al</a>
                            @endif 
                        @else
                            <a href="" class="card-link">Satin al</a>
                        @endif
                    @endforeach
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

 

 

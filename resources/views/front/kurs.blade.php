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

        
        <div class="card card-solid">
            <div class="card-body">
           
            @foreach($courses as $user_k)

               @if($user_k->sold==0)
                <div class="callout callout-success ">
               @else
                    <div class="callout callout-danger ">
                @endif
                        <h5>Course name: {{$user_k->kurs_name}}</h5>
                        <h3 class="my-3">Course price: {{$user_k->price}} azn</h3>
                        <h3 class="my-3">Course discount: {{$user_k->discount}}%</h3>
                        <p> Course content: {{$user_k->kurs_content}}</p>
                        <h6>Teacher name: {{$user_k->name_familya}}</h6>
                        <h6><i>Course share date: {{$user_k->created_at}}</i></h6>
                        @if($user_k->sold==0)
                        <a href="" class="card-link">Satin al</a>
                        @else
                        <a href="{{route('course.cats',$user_k->slug)}}" class="card-link">Kursa goz at</a>
                        @endif
                    </div>
                
             
            @endforeach



            </div>
        </div>    
            

    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

@section('js')
@endsection

 

 

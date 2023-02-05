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

      <!-- Main content -->
      <div class="content">
      <br><div class="card card-solid">
        <div class="card-header"><h2>Ders: {{$lessons->lesson_name}}</h2></div>
        <div class="card-body">
        <p class="text-start">
            <i>Kategori: </i><u>{{$lessons->category->kcat_name}}</u><br>
            <small>Tarix: {{$lessons->created_at}}</small>
        </p>

        <video width="800" height="500" controls="controls" poster="{{$lessons->photo}}" >
            <source src="{{$lessons->les_video}}" type="video/mp4"> 
        </video><br>
        
        <p class="text-start">
            {{$lessons->content_text}}
        </p>
        <a href="{{route('course.tests')}}/{{$lessons->cat_id}}" class="card-link">Movzu haqqinda testler</a>
        </div>
      </div>
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
@endsection
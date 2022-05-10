@extends('layouts.back')
@section('title')
    User Report
@endsection
@section('css')
@endsection

@section('page_name')
    User Report list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
              
                </div>
                <div class="card-body">

                  <div class="table-responsive">
                  <a class="navbar-brand" href="{{route('test.reports')}}">Test reports</a>
                  <a class="navbar-brand" href="{{route('test.reports')}}">Exam reports</a>
                  </div>
                  
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection
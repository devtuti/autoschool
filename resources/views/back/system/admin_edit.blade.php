@extends('layouts.back')
@section('title')
     Update admin
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Admin edit</h4>
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
                  <form action="{{route('admineditpost', $admin->id)}}" method="post">
                    @csrf
                  <div class="row">
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">User name</label>
                          <input type="text" class="form-control" name="username" value="{{$admin->name_familya}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email" value="{{$admin->email}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="number" class="form-control" name="phone" value="{{$admin->phone}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Password</label>
                          <input type="password" class="form-control" name="pass" value="{{$admin->password}}">
                        </div>
                      </div>
                      
                    </div>
                   
                    <button type="submit" class="btn btn-primary pull-right">Update admin</button>
                    <div class="clearfix"></div>
                  
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection
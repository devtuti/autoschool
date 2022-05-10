@extends('layouts.front')
@section('title')
    Login page
@endsection
@section('css')
@endsection

@section('content')
<br>
<div class="container">
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
    <form action="{{route('login')}}" method="post">
        @csrf
        <div class="row align-items-center">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text">Login and password</span>
                    <input type="text" name="name" aria-label="Name" class="form-control" placeholder="Name">
                    <input type="password" name="passwword" aria-label="Password" class="form-control" placeholder="Password">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </div>
      </div>
    </form>
</div>

@endsection

@section('js')
@endsection


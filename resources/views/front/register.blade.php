@extends('layouts.front')
@section('title')
    Register page
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
    <form action="{{route('register')}}" method="post">
        @csrf
        <div class="row align-items-center">
            <div class="col">
                <div class="input-group">
                    
                    <input type="text" aria-label="Name" class="form-control" name="name" placeholder="Name">
                    <input type="email" aria-label="Email" class="form-control" name="email" placeholder="Email">
                    <input type="password" aria-label="Password" class="form-control" name="password" placeholder="Password">
                    
                    <input type="submit" class="btn btn-success" value="Send">
                </div>
            </div>
      </div>
    </form>
</div>

@endsection

@section('js')
@endsection


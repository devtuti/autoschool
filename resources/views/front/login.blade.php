@extends('layouts.front')
@section('title')
    Login page
@endsection
@section('css')
@endsection

@section('content')
<br>
<div class="container">
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


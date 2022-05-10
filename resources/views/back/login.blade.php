@extends('layouts.register')
@section('title')
    Login page
@endsection
        <h2>@section('head')
                Login
            @endsection
        </h2>
        @section('content')
        @if($errors->any())
          <div class="alert alert-danger">
          {{$errors->first()}}
          </div>
        @endif
        <form action="{{route('user_login')}}" method="post">
            @csrf
            <input type="text" name="adminname" id="adminname" placeholder="username" required>
            <input type="password" name="pass" id="pass" placeholder="password " required>
           <div class="btns">
            <button type="submit">Login</button>
            <a href="{{route('register')}}"><button type="button" id="sign-up">Sign Up</button></a>
           </div>
            
        </form>
        @endsection
    
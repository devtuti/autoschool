@extends('layouts.front')
@section('title')
    Login page
@endsection
@section('css')
@endsection

@section('content')
<br>
<div class="container">
    <form action="" method="post">
        @csrf
        <div class="row align-items-center">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text">Login and password</span>
                    <input type="text" aria-label="Name" class="form-control">
                    <input type="password" aria-label="Password" class="form-control">
                    <button type="button" class="btn btn-success">Success</button>
                </div>
            </div>
      </div>
    </form>
</div>

@endsection

@section('js')
@endsection


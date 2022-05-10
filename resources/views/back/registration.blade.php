@extends('layouts.register')
@section('title')
    Register page
@endsection
        <h2>@section('head')
                Registration
            @endsection
        </h2>
        @section('content')
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
        <form action="{{route('user_register')}}" method="post">
            @csrf
       
            <input type="text" name="username" id="username" placeholder="username" required>
            <input type="email" name="email" id="email" placeholder="email" required>
            <input type="number" name="phone" id="phone" pattern="[+]{1}[0-9]{11,14}" placeholder="phone" required>
            <input type="password" name="password" id="pass" placeholder="password" required>
            <input type="password" name="password_confirmation" id="confirm-pass" placeholder=" confirm password" required>

            <div class="btns">
                <button type="submit">Register</button>
            </div>

        </form>
        @endsection
    @section('js')

    <script>
        // lets do some password validation
        const pass = document.querySelector('#pass')
        const confirm_pass = document.querySelector('#confirm-pass')
        const msg = document.querySelector('p')
        const btn = document.querySelector('button')
        btn.addEventListener('click', (e) => {
            if (pass.value != confirm_pass.value) {
                e.preventDefault();
                msg.style.display = "block"
            }else{
                alert('user registered sucessfully')
            }

        })
    </script>
@endsection
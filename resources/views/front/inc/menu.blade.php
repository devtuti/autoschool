<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{Route::is('home') ? 'active' : ''}} " aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{Route::is('about') ? 'active' : ''}}"  href="{{route('about')}}">About</a>
        </li>
        @guest
        <li class="nav-item">
          <a class="nav-link {{Route::is('login') ? 'active' : ''}}"  href="{{route('login')}}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{Route::is('register') ? 'active' : ''}}"  href="{{route('register')}}">Register</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link"  href="javascript:void(0)">{{auth()->user()->name}}</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{Route::is('logout') ? 'active' : ''}}"  href="{{route('logout')}}">Logout</a>
        </li>
        @endguest
        
      </ul>
    </div>
  </div>
</nav>
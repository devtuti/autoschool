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
        
        
      </ul>
    </div>
  </div>
</nav>
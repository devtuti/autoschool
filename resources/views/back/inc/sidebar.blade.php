<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{asset('../assets/img/sidebar-2.jpg')}}">
<!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          AutoSchool
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{Route::is('admin') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('admin')}}">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item {{Route::is('cat') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('cat')}}">
              <i class="material-icons">library_books</i>
              <p>Category</p>
            </a>
          </li>
          
        
        </ul>
      </div>
    </div>
    
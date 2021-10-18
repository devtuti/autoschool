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
          
          
 
          <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">content_copy</i>System</a>
          
          <div class="dropdown-menu">
            <a class="dropdown-item  {{Route::is('cat') ? 'active' : ''}}" href="{{route('cat')}}">Textbook Category</a>
            <a class="dropdown-item  {{Route::is('lesson') ? 'active' : ''}}" href="{{route('lesson')}}">Lessons</a>
            <a class="dropdown-item  {{Route::is('test_question') ? 'active' : ''}}" href="{{route('test_question')}}">Tests</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
      </ul>
        
        
      </div>
    </div>
    
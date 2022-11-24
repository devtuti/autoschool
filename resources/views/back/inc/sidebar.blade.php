<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{asset('../assets/img/sidebar-2.jpg')}}">
<!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          AutoSchool
          <p>
            {{Auth::guard('admin')->user()->name_familya}}
          </p>
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{Route::is('admin') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('admin')}}">
              <i class="material-icons">dashboard</i>
              <p>Home</p>
            </a>
          </li>
          @if(Auth::guard('admin')->user()->grade==1)
            <li class="nav-item {{Route::is('admins') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('admins') ? 'active' : ''}}" href="{{route('admins')}}">
              <i class="material-icons">local_library</i>
              <p>Grade</p>
              </a>
            </li>
          @endif
          @if(Auth::guard('admin')->user()->grade==2)
            <li class="nav-item {{Route::is('users') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('users') ? 'active' : ''}}" href="{{route('users')}}">
                <i class="material-icons">person</i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item {{Route::is('groups') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('groups') ? 'active' : ''}}" href="{{route('groups')}}">
                <i class="material-icons">group</i>
                <p>Groups</p>
            </a>
            </li>
            
            <li class="nav-item {{Route::is('jurnal') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('jurnal') ? 'active' : ''}}" href="{{route('jurnal')}}">
                <i class="material-icons">book</i>
                <p>Jurnal</p>
            </a>
            </li>
            
          @endif
            <li class="nav-item {{Route::is('reports') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('reports') ? 'active' : ''}}" href="{{route('reports')}}">
                <i class="material-icons">book</i>
                <p>Reports</p>
            </a>
            </li>
            <li class="nav-item {{Route::is('user.reports') ? 'active' : ''}}">
              <a class="dropdown-item  {{Route::is('user.reports') ? 'active' : ''}}" href="{{route('user.reports')}}">
                <i class="material-icons">book</i>
                <p>User Reports</p>
            </a>
            </li>
            <li class="nav-item dropdown ">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">content_copy</i>Kurs</a>
          
              <div class="dropdown-menu">
                <a class="dropdown-item  {{Route::is('kurs') ? 'active' : ''}}" href="{{route('kurs')}}">Kurs</a>
                <a class="dropdown-item  {{Route::is('kurs_cat') ? 'active' : ''}}" href="{{route('kurs_cat')}}">Kurs Category</a>
                <a class="dropdown-item  {{Route::is('kurs_lesson') ? 'active' : ''}}" href="{{route('kurs_lesson')}}">Kurs Lesson</a>
                <a class="dropdown-item  {{Route::is('kurs_question') ? 'active' : ''}}" href="{{route('kurs_question')}}">Kurs Tests</a>
                <a class="dropdown-item  {{Route::is('kurs.user') ? 'active' : ''}}" href="{{route('kurs.user')}}">User in the course</a>
              </div>
            </li>

          <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">content_copy</i>System</a>
          
          <div class="dropdown-menu">
            <a class="dropdown-item  {{Route::is('cat') ? 'active' : ''}}" href="{{route('cat')}}">Textbook Category</a>
            <a class="dropdown-item  {{Route::is('lesson') ? 'active' : ''}}" href="{{route('lesson')}}">Lessons</a>
            <a class="dropdown-item  {{Route::is('test_question') ? 'active' : ''}}" href="{{route('test_question')}}">Tests</a>
            <a class="dropdown-item  {{Route::is('car_cat') ? 'active' : ''}}" href="{{route('car_cat')}}">Car Category</a>
            <a class="dropdown-item  {{Route::is('exam_question') ? 'active' : ''}}" href="{{route('exam_question')}}">Exam</a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
      </ul>
        
        
      </div>
    </div>
    
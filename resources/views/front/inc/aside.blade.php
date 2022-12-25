<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{asset('front/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Codemoves</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('users/'.Auth::user()->photo)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('profile')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
          <li class="nav-item menu-open"> 
            <a href="{{route('home')}}" class="nav-link {{Route::is('home') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>
          </li>
      @foreach($groups as $group)
        
        @foreach($jurnal as $j)
        @if($j->status==1)
          @foreach($categories as $cat)
            @if($group->group_id == $j->group_id)
            
              <li class="nav-item menu-open">
                
                
                 
                  <a href="{{route('category')}}/{{$cat->slug}}" class="nav-link @if(Route::is('category')) active @elseif(Route::is('tests')) active  @else '' @endif">
                  
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                  {{$cat->cat_name}}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              
                <ul class="nav nav-treeview">
                @foreach($cat->children as $c)
                  
                    <li class="nav-item">
                      <a href="{{route('category')}}/{{$c->slug}}" class="nav-link {{Route::is('category') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{$c->cat_name}}</p>
                      </a>
                    </li>
                  
                @endforeach
                  </ul>
                            
                </li>
                
            @endif
          @endforeach
          @endif
        @endforeach

    @endforeach
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
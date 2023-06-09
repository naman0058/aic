 <div class="sidebar p-2 py-md-3 @@cardClass">
    <div class="container-fluid">
      <!-- sidebar: title-->
      <div class="title-text d-flex align-items-center mb-4 mt-1">
        <h4 class="sidebar-title mb-0 flex-grow-1"><span class="sm-txt">A</span><span>IC</span></h4>
        
      </div>
      <!-- sidebar: Create new -->
      
      <!-- sidebar: menu list -->
      <div class="main-menu flex-grow-1">
        <ul class="menu-list">
          <li>
            <a class="m-link" href="{{ route('dashboard')}}">
              <i class="fa fa-tachometer" aria-hidden="true"></i>
              <span class="ms-2">My Dashboard</span>
            </a>
          </li>
          @if(\Auth::user()->user_type=='admin')
           <li>
            <a class="m-link" href="{{ route('staff.index')}}">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span class="ms-2">Staff</span>
            </a>
          </li>
		  <li>
            <a class="m-link" href="{{ route('inspection.index')}}">
              <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
              <span class="ms-2">Inspections</span>
            </a>
          </li>
          @endif
          
        </ul>
     
      </div>
   
      <!-- sidebar: footer link -->
      <ul class="menu-list nav navbar-nav flex-row text-center menu-footer-link">
        <li class="nav-item flex-fill p-2">
          <a class="d-inline-block w-100 color-400" href="{{route('logout')}}" title="sign-out">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M7.5 1v7h1V1h-1z" />
              <path class="fill-secondary" d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
            </svg>
          </a>
        </li>
      </ul>
    </div>
  </div>
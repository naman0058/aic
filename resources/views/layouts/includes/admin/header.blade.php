 <header class="page-header sticky-top px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
      <div class="container-fluid">
        <nav class="navbar">
          <!-- start: toggle btn -->
          <div class="d-flex">
            <button type="button" class="btn btn-link d-none d-xl-block sidebar-mini-btn p-0 text-primary">
              <span class="hamburger-icon">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
              </span>
            </button>
            <button type="button" class="btn btn-link d-block d-xl-none menu-toggle p-0 text-primary">
              <span class="hamburger-icon">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
              </span>
            </button>
            <a href="{{route('dashboard')}}" class="brand-icon d-flex align-items-center mx-2 mx-sm-3 text-primary">
                 <img src="{{asset('assets/admin/logo.png')}}">
              
            </a>
          </div>
          <!-- start: search area -->
          <div class="header-left flex-grow-1 d-none d-md-block">
            <div class="main-search px-3 flex-fill">
              <input class="form-control" type="text" placeholder="Enter your search key word">
              
            </div>
          </div>
          <!-- start: link -->
          <ul class="header-right justify-content-end d-flex align-items-center mb-0">
            <!-- start: notifications dropdown-menu -->
          
            <!-- start: My notes toggle modal -->
            <!-- start: User dropdown-menu -->
            <li>
              <div class="dropdown morphing scale-left user-profile mx-lg-3 mx-2">
                <a class="nav-link dropdown-toggle rounded-circle after-none p-0" href="#" role="button" data-bs-toggle="dropdown">
                  <img class="avatar img-thumbnail rounded-circle shadow" src="{{ asset('assets/admin/img/profile_av.png') }}" alt="">
                </a>
                <div class="dropdown-menu border-0 rounded-4 shadow p-0">
                  <div class="card border-0 w240">
                    <div class="card-body border-bottom d-flex">
                      <img class="avatar rounded-circle" src="{{ asset('assets/admin/img/profile_av.png') }}" alt="">
                      <div class="flex-fill ms-3">
                       <h6 class="card-title mb-0">{{ucfirst(Auth::user()->name);}}</h6>
                      
                      </div>
                    </div>
                    <div class="list-group m-2 mb-3">
                      <a class="list-group-item list-group-item-action border-0" href="#"><i class="w30 fa fa-user"></i>My Profile</a> 
                     
                    </div>
                 <a href="{{route('logout')}}" class="btn bg-secondary text-light text-uppercase rounded-0">Sign out</a>
                  </div>
                </div>
              </div>
            </li>
         
          </ul>
        </nav>
      </div>
    </header>
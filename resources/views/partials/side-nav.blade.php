<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header content-header-fullrow px-15">
                <!-- Mini Mode -->
                <div class="content-header-section sidebar-mini-visible-b">
                    <!-- Logo -->
                    <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                        <span class="text-dual-primary-dark">N</span><span class="text-primary">G</span>
                    </span>
                    <!-- END Logo -->
                </div>
                <!-- END Mini Mode -->

                <!-- Normal Mode -->
                <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                    <!-- END Close Sidebar -->

                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700" href="index.html">
                            <i class="si si-fire text-primary"></i>
                            <span class="font-size-xl text-dual-primary-dark">Elect</span><span class="font-size-xl text-primary">NG</span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
                <!-- END Normal Mode -->
            </div>
            <!-- END Side Header -->

            <!-- Side User -->
            <div class="content-side content-side-full content-side-user px-10 align-parent">
                <!-- Visible only in mini mode -->
                <div class="sidebar-mini-visible-b align-v animated fadeIn">
                    <img class="img-avatar img-avatar32" src="{{ asset('images/logo.png') }}" alt="">
                </div>
                <!-- END Visible only in mini mode -->

                <!-- Visible only in normal mode -->
                <div class="sidebar-mini-hidden-b text-center">
                    <a class="img-link" href="be_pages_generic_profile.html">
                        <img class="img-avatar" src="{{ asset('images/logo.png') }}" alt="">
                    </a>
                    <ul class="list-inline mt-10">
                        <li class="list-inline-item">
                            <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="#">{{\Auth::user()->username}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-effect text-dual-primary-dark" href="{{ url('/logout') }}">
                                <i class="si si-logout"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->


            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    
                    <li><a href="{{URL::route('Dashboard')}}"><i class="si si-home"></i><span class="sidebar-mini-hide">Dashboard</span></a></li>
                
                
                    <li><a href="{{URL::route('Election.View')}}"><i class="si si-trophy"></i><span class="sidebar-mini-hide">Elections</span></a></li>
                    
                    <li><a href="{{URL::route('State.View')}}"><i class="si si-cup"></i><span class="sidebar-mini-hide">States</span></a></li>
                    <li><a href="#"><i class="si si-energy"></i><span class="sidebar-mini-hide">Local Govt Areas</span></a></li>
                    <li><a href="{{URL::route('ward.index')}}"><i class="si si-directions"></i><span class="sidebar-mini-hide">Wards</span></a></li>
                    <li><a href="{{URL::route('polling.index')}}"><i class="si si-note"></i><span class="sidebar-mini-hide">Poll Stations</span></a></li>
                    <li><a href="{{URL::route('PP.View')}}"><i class="si si-list"></i><span class="sidebar-mini-hide">Political Parties</span></a></li>

                        
                    <li class="nav-main-heading"><span class="sidebar-mini-visible">___</span><span class="sidebar-mini-hidden">Addons</span></li>
                    <li><a href="{{URL::route('Users.View')}}"><i class="si si-users"></i><span class="sidebar-mini-hide">Users</span></a></li>
                    <li><a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">System Settings</span></a>
                        <ul>
                            <li><a href="#">System Backup</a></li>
                            <li><a href="{{URL::route('preference.uploadView')}}">Bulk Upload</a></li>
                            <li><a href="#">Preferences</a></li>
                            <li><a href="{{URL::route('roles.index')}}">Roles & Permissions</a></li>
                       </ul>
                    </li> 
                    
                </ul>
            </div>
        </div>
    </div>
</nav>
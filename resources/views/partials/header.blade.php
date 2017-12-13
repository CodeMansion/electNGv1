<!-- Header -->
<header id="page-header">
    <div class="content-header">
        <div class="content-header-section">
            <!-- Toggle Sidebar
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Open Search Section -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
                <i class="fa fa-search"></i>
            </button>
            <!-- END Open Search Section -->

            <!-- Layout Options (used just for demonstration) -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary create-hover" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <i class="fa fa-refresh fa-spin ml-5"></i> Quick Links <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-150" aria-labelledby="page-header-user-dropdown">
                    <a class="dropdown-item" href="{{URL::route('Election.View')}}"><i class="si si-note mr-5"></i> View Elections</a>
                    <a class="dropdown-item" href="{{URL::route('Users.View')}}"><span><i class="si si-user"></i> Create User</span></a>
                    <a class="dropdown-item" href="{{URL::route('PP.View')}}"><span><i class="si si-book-open mr-5"></i> Political Parties</span></a>
                    <a class="dropdown-item" href="#"><span><i class="si si-note mr-5"></i> Polling Results</span></a>
                    <a class="dropdown-item" href="#"><i class="si si-users mr-5"></i> User Types</a>
                    <a class="dropdown-item" href="#"><i class="si si-lock mr-5"></i> Roles & Permissions</a>
                    <a class="dropdown-item" href="{{URL::route('preference.uploadView')}}"><i class="si si-cloud-upload mr-5"></i> Bulk Upload</a>
                    <a class="dropdown-item" href="#"><i class="si si-settings mr-5"></i> Preferences</a>
                </div>
                
            </div>
            <!-- END Layout Options -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary create-hover" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="si si-user"></i> {{\Auth::user()->username}} <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-150" aria-labelledby="page-header-user-dropdown">
                    <a class="dropdown-item" href="#"><i class="si si-user mr-5"></i> My Profile</a>
                    @can('view_elections')
                        <a class="dropdown-item" href="#"><span><i class="si si-envelope-open mr-5"></i> Elections</span></a>
                    @endcan
                    <a class="dropdown-item" href="#"><i class="si si-note mr-5"></i> Reports</a>
                    <div class="dropdown-divider"></div>
                    @can('view_system_settings')
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                        <i class="si si-wrench mr-5"></i> Settings
                    </a>
                    @endcan
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                        <i class="si si-question mr-5"></i> Help
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('logout') }}"><i class="si si-logout mr-5"></i> Sign Out</a>
                </div>
            </div>
            <!-- END User Dropdown -->

            <!-- Toggle Side Overlay -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
                <i class="fa fa-tasks"></i>
            </button>
        </div>
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form action="be_pages_generic_search.html" method="post">
                <div class="input-group">
                    <span class="input-group-btn">
                        <!-- Close Search Section -->
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- END Close Search Section -->
                    </span>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
               
    <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div><!-- END Header Loader -->
</header><!-- END Header -->
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a id="index" class="page-logo" href="#"><img class="img-avatar" src="{{ asset('images/logo.png') }}" alt=""> </a>
                <!-- END LOGO -->
                <!-- BEGIN SEARCH -->
                <form class="search" action="extra_search.html" method="GET">
                    <input type="name" class="form-control" name="query" placeholder="Search...">
                    <a href="javascript:;" class="btn submit md-skip">
                        <i class="fa fa-search"></i>
                    </a>
                </form>
                <!-- END SEARCH -->
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">
                    <!-- BEGIN GROUP NOTIFICATION -->
                    <div class="btn-group-notification btn-group" id="header_notification_bar">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge">7</span>
                        </button>
                        <ul class="dropdown-menu-v2">
                            <li class="external">
                                <h3><span class="bold">12 pending</span> notifications</h3>
                                <a href="#">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px; padding: 0;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success md-skip">
                                                    <i class="fa fa-plus"></i>
                                                </span> New user registered. </span>
                                            <span class="time">just now</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END GROUP NOTIFICATION -->
                    <!-- BEGIN USER PROFILE -->
                    <div class="btn-group-img btn-group">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span>Hi, {{\Auth::user()->username}} </span>
                            <img src="../assets/layouts/layout5/img/avatar1.jpg" alt=""> </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-user"></i> My Profile
                                    <span class="badge badge-danger">1</span>
                                </a>
                            </li>
                            <li><a href="{{ url('logout') }}"><i class="icon-key"></i> Log Out </a></li>
                        </ul>
                    </div>
                    <!-- END USER PROFILE -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <button type="button" class="quick-sidebar-toggler md-skip" data-toggle="collapse">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </button>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </div>
                <!-- END TOPBAR ACTIONS -->
            </div>
            <!-- BEGIN HEADER MENU -->
            <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown dropdown-fw dropdown-fw-disabled  active open selected">
                        <a href="{{URL::route('Dashboard')}}" class="text-uppercase"><i class="icon-home"></i> Dashboard </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li class="active"><a href="{{URL::route('Dashboard')}}"><i class="icon-bar-chart"></i> DASHBOARD </a></li>
                            <li><a href="{{URL::route('Election.View')}}"><i class="icon-bulb"></i> ELECTIONS </a></li>
                            <li><a href="#"><i class="icon-puzzle"></i> REPORTS </a></li>
                            <li><a href="{{URL::route('State.View')}}" class="text-uppercase"><i class="icon-briefcase"></i> STATES </a></li>
                            <li><a href="{{URL::route('PP.View')}}" class="text-uppercase"><i class="icon-layers"></i> POLITICAL PARTIES </a></li>
                            <li><a href="{{URL::route('PP.View')}}" class="text-uppercase"><i class="icon-settings"></i> SETTINGS </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->
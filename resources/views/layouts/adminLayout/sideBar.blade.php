<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    @can('isAdmin')
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>
    @endcan
    @cannot('isAdmin')
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/my-reports">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>
    @endcannot

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('isAdmin')
        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ request()->is(['users*', 'floors*']) ? 'active' : '' }}">
            <a class="nav-link {{ request()->is(['users*', 'floors*']) ? '' : 'collapsed' }}" href="#"
               data-toggle="collapse"
               data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseTwo" class="collapse {{ request()->is(['users*', 'floors*']) ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('users*') ? 'active' : '' }}" href="/users">Users</a>
                    <a class="collapse-item {{ request()->is('floors*') ? 'active' : '' }}" href="/floors">Floors</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item {{ request()->is(['reports*','my-reports']) ? 'active' : '' }}">
            <a class="nav-link collapsed {{ request()->is(['reports*','my-reports']) ? '' : 'collapsed' }}" href="#"
               data-toggle="collapse"
               data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-book-open"></i>
                <span>Reports</span>
            </a>
            <div id="collapseUtilities" class="collapse {{ request()->is(['reports*','my-reports']) ? 'show' : '' }}"
                 aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('reports*') ? 'active' : '' }}" href="/reports">Data
                        Report</a>
                    <a class="collapse-item {{ request()->is('my-reports') ? 'active' : '' }}" href="/my-reports">My
                        Report</a>
                </div>
            </div>
        </li>
    @endcan
    @cannot('isAdmin')
        <li class="nav-item {{ request()->is(['reports*','my-reports']) ? 'active' : '' }}">
            <a class="nav-link" href="/my-reports">
                <i class="fas fa-book-open"></i>
                <span>My Reports</span></a>
        </li>
    @endcannot

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

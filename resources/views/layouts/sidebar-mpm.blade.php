<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box mt-2 mb-n3">
        <!-- Light Logo-->
        <a href="admin" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/mpm-logo.png') }}" alt="" height="70">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/mpm-logo.png') }}" alt="" height="70">
            </span>
        </a>
    </div>
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        <a href="admin" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/muet-online-certificate.png') }}" alt="" height="60">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/muet-online-certificate.png') }}" alt="" height="60">
            </span>
        </a>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}"><i class="ri-dashboard-2-line"></i> <span>Dashboard</span></a>
                </li>

                @role('BPKOM|PSM|PENTADBIR')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#POSManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-truck-line"></i><span>POS Management</span>
                    </a>
                    <div class="collapse menu-dropdown show" id="POSManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/new') }}" class="nav-link {{ request()->is('admin/pos-management/new') ? 'active' : '' }}">New</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/processing') }}" class="nav-link {{ request()->is('admin/pos-management/processing') ? 'active' : '' }}">Processing</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/completed') }}" class="nav-link {{ request()->is('admin/pos-management/completed') ? 'active' : '' }}">Completed</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#Reporting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class=" ri-pages-line"></i><span>Reporting</span>
                    </a>
                    <div class="collapse menu-dropdown show" id="Reporting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/transaction') }}" class="nav-link {{ request()->is('admin/transaction') ? 'active' : '' }}">Transaction</a>
                            </li>
                            <li class="nav-item">
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm">Finance
                                </a>
                                <div class="collapse menu-dropdown show" id="sidebarCrm">
                                    <ul class="nav nav-sm flex-column">
                                        @role('FINANCE|PSM|PENTADBIR')
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/finance/muet') }}" class="nav-link {{ request()->is('admin/finance/muet') ? 'active' : '' }}">MUET</a>
                                        </li>
                                        @endrole
                                        @role('FINANCE|BPKOM|PENTADBIR')
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/finance/mod') }}" class="nav-link {{ request()->is('admin/finance/mod') ? 'active' : '' }}">MOD</a>
                                        </li>
                                        @endrole

                                        @role('FINANCE|PENTADBIR')
                                        <li class="nav-item">
                                            <a href="{{ route('finance-statement.index') }}" class="nav-link {{ request()->is('admin/transaction/awdawd') ? 'active' : '' }}">Financial Statement</a>
                                        </li>
                                        @endrole
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                @role('PENTADBIR')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#Administration" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i><span>Administration</span>
                    </a>
                    <div class="collapse menu-dropdown show" id="Administration">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('general_setting.index') }}" class="nav-link">General Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">Users and Access</a>
                            </li>
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="#" class="nav-link">General Configuration</a>--}}
                            {{--                            </li>--}}
                            <li class="nav-item">
                                <a href="{{ route('audit-logs.index') }}" class="nav-link">Audit Logs</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

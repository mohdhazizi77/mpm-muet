<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box mt-2 mb-n3">
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
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
        <a href="index" class="logo logo-light">
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
                    <a href="{{ route('admin.index') }}" class="nav-link"><i class="ri-dashboard-2-line"></i> <span>Dashboard</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#POSManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-truck-line"></i><span>POS Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="POSManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('pos-new.index') }}" class="nav-link">New</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pos-processing.index') }}" class="nav-link">Processing</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pos-completed.index') }}" class="nav-link">Completed</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#Reporting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class=" ri-pages-line"></i><span>Reporting</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Reporting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('transaction.index') }}" class="nav-link">Transaction</a>
                            </li>
                            <li class="nav-item">
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm">Finance
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCrm">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('finance.index') }}" class="nav-link">MUET</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('finance-mod.index') }}" class="nav-link">MOD</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('finance-statement.index') }}" class="nav-link">Financial Statement</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#Administration" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i><span>Administration</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Administration">
                        <ul class="nav nav-sm flex-column">
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

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

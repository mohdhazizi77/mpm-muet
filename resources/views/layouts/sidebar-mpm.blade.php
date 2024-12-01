<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box mt-2 mb-n3 d-block">
        <!-- Light Logo-->
        <a href="{{ route('admin.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/mpm-logo.png') }}" alt="" height="70">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/mpm-logo.png') }}" alt="" height="70">
            </span>
        </a>
    </div>
    <div class="navbar-brand-box d-block">
        <!-- Light Logo-->
        <a href="{{ route('admin.index') }}" class="logo logo-light">
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

            {{-- <div id="two-column-menu"></div> --}}

            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}"><i class="ri-dashboard-2-line"></i> <span>Dashboard</span></a>
                </li>

                @role('BPKOM|PSM|PENTADBIR')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/pos-management*') ? 'active' : '' }} collapsed d-flex justify-content-between align-items-center" href="#POSManagement">
                        <i class="ri-truck-line"></i>
                        <span>POS Management</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </a>

                    <div class="collapse menu-dropdown {{ request()->is('admin/pos-management*') ? 'show' : '' }}" id="POSManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/new') }}" class="nav-link {{ request()->is('admin/pos-management/new') ? 'active' : '' }}">New</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/processing') }}" class="nav-link {{ request()->is('admin/pos-management/processing') ? 'active' : '' }}">In Progress</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/pos-management/completed') }}" class="nav-link {{ request()->is('admin/pos-management/completed') ? 'active' : '' }}">Ready To Pickup</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pos.tracking') }}" class="nav-link {{ request()->is('admin/pos-management/tracking') ? 'active' : '' }}">Track Shipment</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/transaction*') || request()->is('admin/finance*') ? 'active' : '' }} collapsed d-flex justify-content-start align-items-center" href="#Reporting">
                        <i class=" ri-pages-line"></i>
                        <span>Reporting</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->is('admin/transaction*') || request()->is('admin/finance*') ? 'show' : '' }}" id="Reporting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/transaction') }}" class="nav-link {{ request()->is('admin/transaction') ? 'active' : '' }}">Transaction</a>
                            </li>
                            <li class="nav-item">
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarCrm" class="nav-link {{ request()->is('admin/finance*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm">Finance
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
                                            <a href="{{ route('finance-statement.index') }}" class="nav-link {{ request()->is('admin/finance-statement') ? 'active' : '' }}">Financial Statement</a>
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
                    <a class="nav-link menu-link
                    {{ request()->is('admin/general-setting') ? 'active' : '' }}
                    {{ request()->is('admin/config-poslaju') ? 'active' : '' }}
                    {{ request()->is('admin/config-mpmbayar') ? 'active' : '' }}
                    {{ request()->is('admin/users')  ? 'active' : '' }}
                    {{ request()->is('admin/manage-candidate') ? 'active' : '' }}
                    {{ request()->is('admin/pull-db') ? 'active' : '' }}
                    {{ request()->is('admin/audit-logs') ? 'active' : '' }}
                     collapsed d-flex justify-content-between align-items-center" href="#Administration">
                        <i class="ri-apps-2-line"></i>
                        <span>Administration</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                    <div class="collapse menu-dropdown
                    {{ request()->is('admin/general-setting') ? 'show' : '' }}
                    {{ request()->is('admin/config-poslaju') ? 'show' : '' }}
                    {{ request()->is('admin/config-mpmbayar') ? 'show' : '' }}
                    {{ request()->is('admin/users')  ? 'show' : '' }}
                    {{ request()->is('admin/manage-candidate*') ? 'show' : '' }}
                    {{ request()->is('admin/manage-mod-candidate') ? 'show' : '' }}
                    {{ request()->is('admin/pull-db') ? 'show' : '' }}
                    {{ request()->is('admin/audit-logs') ? 'show' : '' }}
                    " id="Administration">
                        <ul class="nav nav-sm flex-column">
                            @role('PENTADBIR')
                                <li class="nav-item">
                                    <a href="{{ route('general_setting.index') }}" class="nav-link {{ request()->is('admin/general-setting') ? 'active' : '' }}">General Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('config_poslaju.index') }}" class="nav-link {{ request()->is('admin/config-poslaju') ? 'active' : '' }}">PosLaju Integration</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('config.mpmbayar.index') }}" class="nav-link {{ request()->is('admin/config-mpmbayar') ? 'active' : '' }}">MPMBayar Integration</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" >Users and Access</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.candidate.index') }}" class="nav-link {{ request()->is('admin/manage-candidate*') ? 'active' : '' }}">Candidates</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('admin.mod_candidate.index') }}" class="nav-link {{ request()->is('admin/manage-mod-candidate') ? 'active' : '' }}">MOD Candidates</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.pullDB') }}" class="nav-link {{ request()->is('admin/pull-db') ? 'active' : '' }}">Pull DB Candidates</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('audit-logs.index', ['userType' => 'Admin']) }}" class="nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}">Audit Logs [ADMIN]</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('audit-logs.index', ['userType' => 'Candidate']) }}" class="nav-link {{ request()->is('admin/audit-logs') ? 'active' : '' }}">Audit Logs [CANDIDATE]</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="#auditLogMenu" class="nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="auditLogMenu">Audit Logs
                                    </a>
                                    <div class="collapse menu-dropdown show" id="auditLogMenu">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('audit-logs.index', ['userType' => 'Admin']) }}" class="nav-link {{ request()->is('admin/audit-logs?userType=Admin') ? 'active' : '' }}">Admin</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('audit-logs.index', ['userType' => 'Candidate']) }}" class="nav-link {{ request()->is('admin/audit-logs?userType=Candidate') ? 'active' : '' }}">Candidate</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endrole

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

<script>
    $(document).ready(function() {
        $('a[href="#POSManagement"]').on('click', function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#POSManagement').toggleClass('show');
        });

        $('a[href="#Reporting"]').on('click', function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#Reporting').toggleClass('show');
        });

        $('a[href="#Administration"]').on('click', function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#Administration').toggleClass('show');
        });
        });
</script>

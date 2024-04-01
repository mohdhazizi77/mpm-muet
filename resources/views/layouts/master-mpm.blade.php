<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="semibox" data-layout-style="default" data-layout-position="fixed" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-layout-width="fluid">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | MPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico')}}">
    @include('layouts.head-css')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    @include('layouts.topbar-mpm')
    @include('layouts.sidebar-mpm')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <!-- Start content -->
            <div class="container-fluid">
                @yield('content')
            </div> <!-- content -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
@include('layouts.customizer')
<!-- END Right Sidebar -->

@include('layouts.vendor-scripts')
</body>

</html>

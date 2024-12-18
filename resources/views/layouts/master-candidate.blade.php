<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-layout-width="fluid" data-layout-position="fixed" data-topbar="dark">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | MPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistem Sijil MUET Online MPM | Portal Paparan Sijil Keputusan MUET dan Pembelian Sijil Keputusan MUET daripada MPM" name="description"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('layouts.head-css')
    <style>
        @media (max-width: 767px) {
            .container-fluid {
                margin-top: 10px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/js/app.js'])
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
    {{-- @vite(['resources/sass/app.scss']) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    @include('layouts.topbar-candidate')
    {{--    @include('layouts.sidebar')--}}
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
        {{--        @include('layouts.footer')--}}
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

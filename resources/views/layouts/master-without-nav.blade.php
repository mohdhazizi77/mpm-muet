<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | MPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('layouts.head-css')
    <style>
        .layout-width {
            max-width: 100%; /* Ensures it can adapt to any screen size */
            padding: 0 15px; /* Adjust padding as needed */
            margin: 0 auto; /* Centers the layout horizontally */
        }

        @media (max-width: 767px) {
            .content-wrapper {
                margin-top: 110px; /* Adjust as needed */
            }
        }
    </style>
</head>

@yield('body')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.topbar-without-logout')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
</div>




@include('layouts.vendor-scripts')
</body>
</html>

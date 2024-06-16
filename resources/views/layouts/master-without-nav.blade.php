
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
        #page-top {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1002;
            background-color: #132649;
            transition: all 0.1s ease-out;
            border-bottom: 1px solid #132649;
        }
        #page-top.topbar-shadow {
            box-shadow: 0 1px 2px #38414a26;
        }

        @media (max-width: 767px) {
            .content-wrapper {
                margin-top: 110px;
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .content-wrapper {
                padding: 25px 20px; /* Moderate padding for tablets */
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

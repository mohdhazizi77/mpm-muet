@extends('layouts.master-mpm')
@section('title')
    Dashboard
@endsection
@section('css')
    <!-- plugin css -->
    <link href="build/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css"/>

    <link href="build/libs/swiper/swiper-bundle.min.css" rel="stylesheet"/>

    <style>
        .gradient-card {
            /* background: linear-gradient(270deg, #66ffff, #0099ff, #66ffff); */
            background: linear-gradient(to left, #78D5f5 0%, #787ff6 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 8s ease infinite; */
        }
        .gradient-card-second {
            background: linear-gradient(to left, #78D5f5 0%, #787ff6 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 9s ease infinite; */
        }
        .gradient-card-third {
            background: linear-gradient(to left, #78D5f5 0%, #787ff6 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 10s ease infinite; */
        }

        .gradient-card-yellow {
            /* background: linear-gradient(270deg, #ffcccc, #ff9900, #ffcccc); */
            background: linear-gradient(to left, #ffbe88 0%, #ffcc66 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 5s ease infinite; */
        }
        .gradient-card-yellow-second {
            background: linear-gradient(to left, #ffbe88 0%, #ffcc66 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 6s ease infinite; */
        }
        .gradient-card-yellow-third {
            background: linear-gradient(to left, #ffbe88 0%, #ffcc66 100%);
            /* background-size: 600% 600%; */
            /* animation: gradientAnimation 7s ease infinite; */
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
@endsection
@section('content')

    @role('PENTADBIR|PSM|BPKOM')
        <div class="row">
            <div class="col-12">
                <h5 class="text-decoration-underline mb-3 pb-1">Daily Activity Counts ({{ date('d/m/Y') }})</h5>
            </div>
        </div>
        <div class="row">
            @role('PENTADBIR|PSM')
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">View Result MUET</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $dailyCounts['viewsMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">Download Result MUET</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $dailyCounts['downloadsMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
            @role('PENTADBIR|BPKOM')
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">View Result MOD</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $dailyCounts['viewsMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">DOwnload Result MOD</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $dailyCounts['downloadsMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Total View Ceritificate for Year 2024</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="line_chart_view_muet_mod" data-colors='["--vz-primary", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Total Download Ceritificate for Year 2024</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="line_chart_download_muet_mod" data-colors='["--vz-primary", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    @endrole


    @role('PSM|PENTADBIR')
        <div class="row">
            <div class="col-12">
                <h5 class="text-decoration-underline mb-3 pb-1">MUET</h5>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate gradient-card">
                    <div class="card-body text-dark">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;color: #fff">NEW</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class=" fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;color: #fff">
                                        <span class="counter-value" id="muetNew-count" data-target="1234">{{ $count['orderNewMUET'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 20px">
                                <div class="align-middle text-center">
                                    <img src="{{ asset('build/images/dashboard/megaphone_white.png') }}" width="60px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-opacity-50 gradient-card-second">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;color: #fff">PROCESSING</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class="fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;color: #fff">
                                        <span class="counter-value" data-target="1234">{{ $count['orderProcessingMUET'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 20px">
                                <div class="align-middle text-center">
                                    {{-- <i class="fas fa-location-arrow text-dark" style="font-size: 50px;"></i> --}}
                                    {{-- <i class="ri-star-fill" style="font-size: 24px;"></i> --}}
                                    <img src="{{ asset('build/images/dashboard/process_white.png') }}"
                                                    width="60px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate gradient-card-third">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;color: #fff">COMPLETED</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class="fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;color: #fff">
                                        <span class="counter-value" data-target="6000">{{ $count['orderCompleteMUET'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 10px">
                                <div class="align-middle text-center">
                                    {{-- <i class="fas fa-location-arrow text-dark" style="font-size: 50px;"></i> --}}
                                    {{-- <i class="ri-star-fill" style="font-size: 24px;"></i> --}}
                                    <img src="{{ asset('build/images/dashboard/checked_white.png') }}"
                                                    width="80px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->

        </div>
    @endrole

    @role('BPKOM|PENTADBIR')
        <div class="row">
            <div class="col-12">
                <h5 class="text-decoration-underline mb-3 pb-1">MOD</h5>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate gradient-card-yellow" >
                    <div class="card-body text-dark">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;">NEW</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class="fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;">
                                        <span class="counter-value" id="muetNew-count" data-target="1234">{{ $count['orderNewMOD'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 10px">
                                <div class="align-middle text-center">
                                    {{-- <i class="fas fa-location-arrow text-dark" style="font-size: 50px;"></i> --}}
                                    {{-- <i class="ri-star-fill" style="font-size: 24px;"></i> --}}
                                    <img src="{{ asset('build/images/dashboard/megaphone_black.png') }}"
                                                    width="60px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-opacity-50 gradient-card-yellow-second">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;">PROCESSING</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class="fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;">
                                        <span class="counter-value" data-target="1234">{{ $count['orderProcessingMOD'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 10px">
                                <div class="align-middle text-center">
                                    {{-- <i class="fas fa-location-arrow text-dark" style="font-size: 50px;"></i> --}}
                                    {{-- <i class="ri-star-fill" style="font-size: 24px;"></i> --}}
                                    <img src="{{ asset('build/images/dashboard/process_black.png') }}"
                                                    width="60px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate gradient-card-yellow-third">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-6" style="padding-left: 20px">
                                <div>
                                    <p class="text-uppercase fw-semibold mb-0" style="font-weight: bolder; font-size: 15pt;">COMPLETED</p>
                                </div>
                                <div class="mt-3">
                                    <h1 class="fw-semibold ff-secondary mb-2" style="font-weight: bolder; font-size: 30pt;">
                                        <span class="counter-value" data-target="6000">{{ $count['orderCompleteMOD'] }}</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="col" style="padding-top: 10px; padding-bottom: 10px">
                                <div class="align-middle text-center">
                                    {{-- <i class="fas fa-location-arrow text-dark" style="font-size: 50px;"></i> --}}
                                    {{-- <i class="ri-star-fill" style="font-size: 24px;"></i> --}}
                                    <img src="{{ asset('build/images/dashboard/checked_black.png') }}"
                                                    width="80px" class="icon-info">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

        </div>
    @endrole

    <div class="row">
        <div class="col-12">
            <h5 class="text-decoration-underline mb-3 pb-1">FINANCE</h5>
        </div>
    </div>

    @role('FINANCE|PSM|PENTADBIR')
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MUET (RM{{ $rateMpmPrint }})</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMUET_mpmprint'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #bce6ff">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MUET (RM{{ $rateSelfPrint }})</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMUET_selfprint'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #7fcdfa">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">TOTAL COLLECTION</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

        </div>
    @endrole

    @role('FINANCE|BPKOM|PENTADBIR')
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #aab6fb">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MOD (RM{{ $rateMpmPrint }})</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMOD_mpmprint'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #aab6fb">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MOD (RM{{ $rateSelfPrint }})</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMOD_selfprint'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #8798fb">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">TOTAL COLLECTION</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

        </div>
    @endrole


    <div class="row">
        @role('PSM|PENTADBIR')
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">MUET Collection</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div id="piechart_muet"
                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                            class="apex-charts" dir="ltr"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        @endrole

        @role('BPKOM|PENTADBIR')
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">MOD Collection</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div id="piechart_mod"
                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                            class="apex-charts" dir="ltr"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        @endrole

    </div>

    <div class="row">
        @role('FINANCE|PENTADBIR')
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Total Collection for Year 2024</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="line_chart_muet_mod" data-colors='["--vz-primary", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        @endrole
    </div>

@endsection
@section('script')
    <script>

    </script>
    <!-- apexcharts -->
    {{-- <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-pie.init.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-column.init.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-line.init.js') }}"></script> --}}



    <!-- Widget init -->

    {{-- <script src="{{ URL::asset('build/js/app.js') }}"></script> --}}


@endsection

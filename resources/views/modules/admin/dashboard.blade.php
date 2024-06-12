@extends('layouts.master-mpm')
@section('title')
    Dashboard
@endsection
@section('css')
    <!-- plugin css -->
    <link href="build/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css"/>

    <link href="build/libs/swiper/swiper-bundle.min.css" rel="stylesheet"/>
@endsection
@section('content')

    @role('PSM|PENTADBIR')
        <div class="row">
            <div class="col-12">
                <h5 class="text-decoration-underline mb-3 pb-1">MUET</h5>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">NEW</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" id="muetNew-count" data-target="1234">{{ $count['orderNewMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-warning bg-opacity-50">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">PROCESSING</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="1234">{{ $count['orderProcessingMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-secondary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">COMPLETED</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $count['orderCompleteMUET'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

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
                <div class="card card-animate bg-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">NEW</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="1234">{{ $count['orderNewMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-warning bg-opacity-50">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">PROCESSING</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="1234">{{ $count['orderProcessingMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate bg-secondary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">COMPLETED</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">{{ $count['orderCompleteMOD'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
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
                <div class="card card-animate" style="background-color: #b38ed5e7">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MUET (RM60)</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMUET60'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #f86624">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MUET (RM20)</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMUET20'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #68d4cd">
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
                <div class="card card-animate" style="background-color: #b38ed5e7">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MOD (RM60)</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMOD60'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #f86624">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold mb-0">MOD (RM20)</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="6000">RM {{ $count['totalMOD20'] }}</span>
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-4 col-md-6">
                <!-- card -->
                <div class="card card-animate" style="background-color: #cff67b">
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
            <div class="col-xl-3">
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
            <div class="col-xl-3">
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


        @role('FINANCE|PENTADBIR')
            <div class="col-xl-6">
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
    <!-- apexcharts -->
    {{-- <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-pie.init.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-column.init.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/apexcharts-line.init.js') }}"></script> --}}



    <!-- Widget init -->

    {{-- <script src="{{ URL::asset('build/js/app.js') }}"></script> --}}


@endsection

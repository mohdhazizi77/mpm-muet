@extends('layouts.master-mpm')
@section('title')
    Reporting (Finance - MOD)
@endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Reporting
        @endslot
        @slot('title')
            Finance - MOD
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-secondary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">Successful Transaction</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">{{ $count['totalSuccess'] }}</span></h4>
                                            </div>

                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - RM60</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">{{ $count['totalPay60'] }}</span></h4>
                                            </div>

                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - RM20</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">{{ $count['totalPay20'] }}</span></h4>
                                            </div>

                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL COLLECTION</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">RM {{ $count['totalCollect'] }}</span></h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                        </div>

                        {{-- Filter --}}
                        <div class="row gy-1">
                            <div class="col-md-3">
                                <label for="start-date" class="form-label">Start Date:</label>
                                <input type="date" id="start-date-fin-mod" class="form-control datepicker" placeholder="DD-MM-YYYY">
                            </div>
                            <div class="col-md-3">
                                <label for="end-date" class="form-label">End Date:</label>
                                <input type="date" id="end-date-fin-mod" class="form-control datepicker" placeholder="DD-MM-YYYY" disabled>
                            </div>
                            <div class="col-md-3" style="align-content: end;">
                                <button id="filterBtnFinMod" class="btn btn-primary">Filter</button>
                                <button id="resetBtnFinMod" class="btn btn-secondary">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <label for="text-search-fin-mod" class="form-label">Search:</label>
                                <input type="text" id="text-search-fin-mod" class="form-control" placeholder="Enter id">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="py-4">
                                <table id="financeModTable" class="table w-100 table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">TRANSACTION ID</th>
                                        <th scope="col">RECEIPT NO.</th>
                                        <th scope="col">TRANSACTION DATE</th>
                                        <th scope="col">CANDIDATE NAME</th>
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">RECEIPT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                                    <tr class="align-middle">--}}
                                    {{--                                        <th scope="row">1</th>--}}
                                    {{--                                        <td>25/11/2023</td>--}}
                                    {{--                                        <td>2312071620520408</td>--}}
                                    {{--                                        <td>MUET Certificate (MPM) | Session 1, 2020 | Ali Bin Abu | 1234567890</td>--}}
                                    {{--                                        <td><h5><span class="badge rounded-pill bg-primary">NEW</span></h5></td>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <button type="button" class="btn btn-success btn-icon waves-effect waves-light me-2"><i class="ri-check-line"></i></button>--}}
                                    {{--                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light me-2"><i class="ri-close-line"></i></button>--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}
                                    {{--                                    <tr class="align-middle">--}}
                                    {{--                                        <th scope="row">2</th>--}}
                                    {{--                                        <td>21/11/2023</td>--}}
                                    {{--                                        <td>2312080113550968</td>--}}
                                    {{--                                        <td>MUET Certificate (MPM) | Session 1, 2020 | Ali Bin Abu | 1234567890</td>--}}
                                    {{--                                        <td><h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5></td>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button>--}}
                                    {{--                                            <button type="button" class="btn btn-secondary btn-icon waves-effect waves-light me-2"><i class="ri-printer-line"></i></button>--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}
                                    {{--                                    <tr class="align-middle">--}}
                                    {{--                                        <th scope="row">3</th>--}}
                                    {{--                                        <td>15/11/2023</td>--}}
                                    {{--                                        <td>2312080116370971</td>--}}
                                    {{--                                        <td>MUET Certificate (MPM) | Session 1, 2020 | Ali Bin Abu | 1234567890</td>--}}
                                    {{--                                        <td><h5><span class="badge rounded-pill bg-success">COMPLETED</span></h5></td>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button>--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}
                                    {{--                                    <tr class="align-middle">--}}
                                    {{--                                        <th scope="row">4</th>--}}
                                    {{--                                        <td>12/11/2023</td>--}}
                                    {{--                                        <td>2312080950550195</td>--}}
                                    {{--                                        <td>MUET Certificate (MPM) | Session 1, 2020 | Ali Bin Abu | 1234567890</td>--}}
                                    {{--                                        <td><h5><span class="badge rounded-pill bg-warning">CANCELLED</span></h5></td>--}}
                                    {{--                                        <td>--}}
                                    {{--                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button>--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}
                                    {{--                                    </tbody>--}}
                                </table>

                            </div>
                        </div>
                        {{--                        <div class="col-xxl-3 ms-auto">--}}
                        {{--                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">--}}
                        {{--                                <img src="{{ asset('build/images/faq-img.png') }}" alt="" class="img-fluid">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
        <!--end col-->
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {
            $("#basicDate").flatpickr(
                {
                    mode: "range",
                    dateFormat: "d-m-Y",
                }
            );
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>
    <script src="{{ asset('build/js/datatables/report-finance.js') }}"></script>

@endsection


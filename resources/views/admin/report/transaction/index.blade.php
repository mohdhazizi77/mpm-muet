@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')
    {{-- <!-- DataTables --> --}}

    <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme -->
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Reporting
        @endslot
        @slot('title')
            Transaction
        @endslot
    @endcomponent




    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-1">
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">Date Range</label>
                                    <input class="form-control" id="basicDate" type="text" placeholder="" data-flatpickr>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end">EXPORT XLSX</button>
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT PDF</button>
                            </div>

                            <div class="py-4">
                                {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                <!-- Striped Rows -->

                                <table id="dt-pos" class="table w-100 table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">DATE</th>
                                        <th scope="col">TRANSACTION ID</th>
                                        <th scope="col">DETAILS</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">UPDATED DATE</th>
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
    <script src="{{ asset('build/js/datatables/report-transaction.js') }}"></script>

@endsection


@extends('layouts.master-mpm')
@section('title')
    Reporting (Finance - MUET)
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
            Finance > MUET
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
                                                <p class="text-uppercase fw-semibold text-white mb-0">Total Transaction</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    {{-- <span class="counter-value" data-target="36894">{{ $count['totalSuccess'] }}</span> --}}
                                                    <span class="counter-value" data-target="36894" id="total_success">0</span>
                                                </h4>
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
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - MPM PRINT</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    {{-- <span class="counter-value" data-target="36894">{{ $count['totalPay60'] }}</span> --}}
                                                    <span class="counter-value" data-target="36894" id="mpm_print">0</span>
                                                </h4>
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
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - SELF PRINT</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    {{-- <span class="counter-value" data-target="36894">{{ $count['totalPay20'] }}</span> --}}
                                                    <span class="counter-value" data-target="36894" id="self_print">0</span>
                                                </h4>
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
                                                    {{-- <span class="counter-value" data-target="36894">RM {{ $count['totalCollect'] }}</span></h4> --}}
                                                    <span class="counter-value" data-target="36894" id="total_collection">RM 0</span></h4>
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
                                <input type="date" id="start-date-fin-muet" class="form-control datepicker" value="{{ date('d-m-y') }}" placeholder="DD-MM-YYYY">
                            </div>
                            <div class="col-md-3">
                                <label for="end-date" class="form-label">End Date:</label>
                                <input type="date" id="end-date-fin-muet" class="form-control datepicker" value="{{ date('d-m-y') }}" placeholder="DD-MM-YYYY">
                            </div>
                            <div class="col-md-3" style="align-content: end;">
                                <button id="filterBtnFinMuet" class="btn btn-primary">Filter</button>
                                <button id="resetBtnFinMuet" class="btn btn-secondary">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <label for="text-search-fin-muet" class="form-label">Search:</label>
                                <input type="text" id="text-search-fin-muet" class="form-control" placeholder="Enter id">
                            </div>
                        </div>

                        <div class="row gy-1 mt-2">
                            <div class="col-md-3">
                                {{-- <label for="start-date" class="form-label">Exam type</label>
                                <select name="exam_type" id="exam_type" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="MUET">MUET</option>
                                    <option value="MOD">MOD</option>
                                </select> --}}
                                <label for="start-date" class="form-label">Status</label>
                                <select name="status_muet" id="status_muet" class="form-control">
                                    <option value="">Please Select</option>
                                    <option selected value="SUCCESS">SUCCESS</option>
                                    <option value="PENDING">PENDING</option>
                                    <option value="FAILED">FAILED</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="end-date" class="form-label">Payment For</label>
                                <select name="payment_for" id="payment_for" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="MPM_PRINT">MPM PRINT</option>
                                    <option value="SELF_PRINT">SELF PRINT</option>
                                </select>
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
                    <div class="row p-0">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                <button id="button-export-pdf-fin" target="_blank"  type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT PDF</button>
                                <button id="button-export-xlsx-fin"  type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 align-self-center">

                            <table id="financeMuetTable" class="table w-100 table-striped text-center dt-responsive nowrap dataTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr class="text-center bg-dark-subtle">
                                    {{-- Transaction ID | Receipt No. | Date | Candidate Name | Amount | Status | Receipt --}}
                                    <th scope="col">TRANSACTION ID</th>
                                    <th scope="col">RECEIPT NO.</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">CANDIDATE NAME</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">RECEIPT</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                                </thead>
                                <tbody>

                            </table>
                        </div>
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

@endsection


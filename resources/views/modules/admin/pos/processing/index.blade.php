@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')
    <style>
        .toggle-button {
            display: inline-block;
            width: 60px;
            height: 30px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        .toggle-button:before {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            width: 28px;
            height: 28px;
            background-color: #ccc;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .toggle-button.active:before {
            transform: translateX(30px);
            background-color: #28a745; /* Green color for active state */
        }
        .toggle-button .status {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: #333;
        }

    </style>
    {{-- <!-- DataTables --> --}}

    {{-- <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme --> --}}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            POS Management
        @endslot
        @slot('title')
            Processing
        @endslot
    @endcomponent

    <div class="row px-1">
        <div class="card rounded-0 bg-white border-top px-3">
            <div class="p-4">
                <div class="row mb-3">
                    <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                        <label for="start-date" class="form-label">Start Date:</label>
                        <input type="date" id="start-date" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                        <label for="end-date" class="form-label">End Date:</label>
                        <input type="date" id="end-date" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    @role('PENTADBIR')
                    {{-- <div class="row gy-1 mt-2"> --}}
                        <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                            <label for="exam_type" class="form-label">Exam type</label>
                            <select name="exam_type" id="exam_type" class="form-control">
                                <option value="">Please Select</option>
                                <option value="MUET">MUET</option>
                                <option value="MOD">MOD</option>
                            </select>
                        </div>
                    {{-- </div> --}}
                    @endrole
                    <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                        <label for="text-search" class="form-label">Text Search:</label>
                        <input type="text" id="text-search" class="form-control" placeholder="Enter text">
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="checkbox" class="btn-check" id="noTracking" value="0">
                                <label id="noTrackingLabel" class="btn btn-outline-secondary material-shadow" for="noTracking">Get Orders Without Tracking</label>
                            </div>
                            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                <button id="filterBtn" class="btn btn-primary">Filter</button>
                                <button id="resetBtn" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    {{-- <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                <button id="button-import-pos-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">IMPORT POS XLSX</button>
                                <button id="button-export-pos-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT POS XLSX</button>
                                <button id="button-export-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>
                            <div class="float-end my-3">
                                <button type="button" id="btnBulkProcessing" class="btn btn-soft-success waves-effect float-end mx-1">COMPLETE</button>
                                <button type="button" id="btnBulkPrintProcessing" class="btn btn-soft-success waves-effect float-end ">PRINT CERTIFICATE</button>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xxl-12 align-self-center">
                        <div class="d-flex flex-wrap justify-content-between my-3">
                            <!-- Left Buttons -->
                            <div class="mb-2">
                                <button id="button-import-pos-xlsx" type="button" class="btn btn-soft-secondary waves-effect mx-1">IMPORT POS XLSX</button>
                                <button id="button-export-pos-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect mx-1">EXPORT POS XLSX</button>
                                <button id="button-export-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect mx-1">EXPORT XLSX</button>
                            </div>
                            <!-- Right Buttons -->
                            <div class="mb-2">
                                <button type="button" id="btnBulkProcessing" class="btn btn-soft-success waves-effect mx-1">COMPLETE</button>
                                <button type="button" id="btnBulkPrintProcessing" class="btn btn-soft-success waves-effect">PRINT CERTIFICATE</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                            <div class="py-1">

                                <table id="posProcessTable" data-type="PROCESSING" class="table w-100 table-striped dt-responsive nowrap dataTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col"><input type="checkbox" class="form-check-input row-checkbox check-all"></th>
                                        <th scope="col">DATE</th>
                                        <th scope="col">REFERENCE ID</th>
                                        <th scope="col" style="text-align:left;">DETAILS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
        <!--end col-->
    </div>

    {{--MODAL UPDATE POS--}}
    <div class="modal fade modalUpdatePos" id="modalUpdatePos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"></button>

                <div class="container mt-3">
                    <div class="row mx-3">
                        <div class="col-xl-12">


                            <div class="row pt-3">
                                <div class="col-lg-12">
                                    <div class="card rounded-0 bg-white mx-n4 border-top">

                                        <div class="card-header bg-dark-subtle">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="card-title mb-0 fs-20 fw-bolder">Candidate's Information</h5>
                                                </div>
                                            </div>
                                        </div><!-- end card header -->

                                        <div class="px-4">
                                            <div class="row">
                                                <div class="col-xl-12">


                                                    <div class="py-4">

                                                        <form action="javascript:void(0);">

                                                            <div class="row">
                                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Name</label>
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your name" id="name" name="name" value="">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="icNumber" class="form-label">Identification Card Number</label>
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your identification card number" id="nric" name="nric" value="">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            {{-- <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Phone Number</label>
                                                                    <div class="input-group" data-input-flag>
                                                                        <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                                src="{{URL::asset('build/images/flags/my.svg')}}"
                                                                                alt="flag img" height="20"
                                                                                class="country-flagimg rounded"><span
                                                                                class="ms-2 country-codeno">+60</span></button>
                                                                        <input disabled type="text" class="form-control rounded-end flag-input" value="" placeholder="Enter your phone number" name
                                                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                                                        <div class="dropdown-menu w-100">
                                                                            <div class="p-2 px-3 pt-1 searchlist-input">
                                                                                <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..."/>
                                                                            </div>
                                                                            <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email</label>
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your email" id="email" value="">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row--> --}}

                                                            {{-- <div class="row">

                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="address" class="form-label">Address</label>
                                                                        <input disabled  type="text" class="form-control" placeholder="Enter your address" id="address" name="address" value="">
                                                                    </div>
                                                                </div>

                                                            </div> --}}

                                                            {{-- <div class="row">

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="postcode" class="form-label">Postcode</label>
                                                                        <input disabled  type="text" class="form-control" placeholder="Enter your postcode" id="postcode" name="postcode" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">City</label>
                                                                        <input disabled  type="text" class="form-control" placeholder="Enter your city" id="city" name="city" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="state" class="form-label" >State</label>
                                                                        <select readonly class="form-select mb-3" id="state"  disabled>
                                                                            <option selected disabled>Select State</option>
                                                                            @foreach (App\Models\User::getStates() as $key => $value)
                                                                                <option value="{{ $key }}" @if(old('state') == $key) selected @endif>{{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div> --}}

                                                        </form>

                                                    </div>


                                                </div>

                                            </div>

                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!--end col-->
                            </div>

                            <div class="row shipping_info">
                                <div class="col-lg-12">
                                    <div class="card rounded-0 bg-white mx-n4 border-top">

                                        <div class="card-header bg-dark-subtle">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="card-title mb-0 fs-20 fw-bolder">Shipping Information</h5>
                                                </div>
                                            </div>
                                        </div><!-- end card header -->

                                        <div class="px-4">
                                            <div class="row">
                                                <div class="col-xl-12">


                                                    <div class="py-4">

                                                        <form action="javascript:void(0);">

                                                            <div class="row">
                                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Name</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your name" id="ship_name" name="ship_name" value="" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="ship_phoneNum" class="form-label">Phone Number</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your phone_number" id="ship_phoneNum" name="ship_phoneNum" value="" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">
                                                                {{-- <div class="col-6">
                                                                    <label class="form-label">Phone Number</label>
                                                                    <div class="input-group" data-input-flag>
                                                                        <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                                src="{{URL::asset('build/images/flags/my.svg')}}"
                                                                                alt="flag img" height="20"
                                                                                class="country-flagimg rounded"><span
                                                                                class="ms-2 country-codeno">+60</span></button>
                                                                        <input disabled type="text" class="form-control rounded-end flag-input"  placeholder="Enter your phone number" value=""
                                                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                                                        <div class="dropdown-menu w-100">
                                                                            <div class="p-2 px-3 pt-1 searchlist-input">
                                                                                <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..."/>
                                                                            </div>
                                                                            <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your email" id="ship_email" name="ship_email" value="" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">

                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="address" class="form-label">Address</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your address" id="ship_address" name="ship_address" value="" required>
                                                                    </div>
                                                                </div><!--end col-->

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="postcode" class="form-label">Postcode</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your postcode" id="ship_postcode" name="ship_postcode" value="" required>
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">City</label>
                                                                        <input type="text" class="form-control" placeholder="Enter your city" id="ship_city" name="ship_city" value="" required>
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="state" class="form-label" >State</label>
                                                                        <select  class="form-select mb-3" id="ship_state" name="ship_state" required>
                                                                            <option selected disabled>Select State</option>
                                                                            @foreach (App\Models\User::getStates() as $key => $value)
                                                                                <option value="{{ $key }}" @if(old('state') == $key) selected @endif>{{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label for="track_num" class="form-label">Tracking Number</label>
                                                                        <input type="text" class="form-control" placeholder="Enter tracking number" id="ship_trackNum" name="ship_trackNum" value=""  required>
                                                                    </div>
                                                                </div><!--end col-->

                                                                {{-- <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="track_remarks" class="form-label">Notes</label>
                                                                        <input type="text" class="form-control" placeholder="" id="ship_trackRemarks" name="ship_trackRemarks" value="" >
                                                                    </div>
                                                                </div> --}}

                                                            </div>
                                                            <input type="text" id="order_id" name="order_id" value="" style="display: none">


                                                        </form>

                                                    </div>


                                                </div>

                                            </div>

                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!--end col-->
                            </div>


                        </div>

                    </div>

                    <div class="modal-footer">
                        {{-- <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a> --}}
                        <a href='#' id="button-print-certificate-pdf" class="btn btn-outline-secondary float-end" target="_blank">Print Certificate</a>
                        <a id="button-save-pos-processing" class="btn btn-outline-secondary float-end">Save</a>
                        <button type="button" class="btn btn-outline-success float-end btn-approve-processing">Complete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modules.admin.pos.processing.modal.upload')
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {

            // $('#button-export-xlsx').on('click', function (e) {

            //     e.preventDefault();
            //     window.location.href = 'pos-processing/export-xlsx';

            // })

            // $('#button-export-pos-xlsx').on('click', function (e) {

            //     e.preventDefault();
            //     window.location.href = 'pos-processing/export-pos-xlsx';

            // })

            // $('#button-print-certificate-pdf').on('click', function (e) {

            //     e.preventDefault();
            //     window.location.href = route('mpm.downloadpdf');

            // })


            // $("#basicDate").flatpickr(
            //     {
            //         mode: "range",
            //         dateFormat: "d-m-Y",
            //     }
            // );
        });


    </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>
    <script src="{{ asset('build/js/datatables/pos-processing.js') }}"></script> --}}

@endsection


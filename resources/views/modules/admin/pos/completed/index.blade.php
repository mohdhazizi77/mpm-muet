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
            POS Management 123
        @endslot
        @slot('title')
            Completed
        @endslot
    @endcomponent

    <div class="row px-1">
        <div class="card rounded-0 bg-white border-top px-2">
            <div class="p-4">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start-date" class="form-label">Start Date:</label>
                        <input type="date" id="start-date" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-3">
                        <label for="end-date" class="form-label">End Date:</label>
                        <input type="date" id="end-date" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-3" style="align-content: end;">
                            <button id="filterBtn" class="btn btn-primary">Filter</button>
                            <button id="resetBtn" class="btn btn-secondary">Reset</button>
                    </div>
                    <div class="col-md-3">
                        <label for="text-search" class="form-label">Text Search:</label>
                        <input type="text" id="text-search" class="form-control" placeholder="Enter text">
                    </div>
                </div>
                @role('PENTADBIR')
                <div class="row gy-1 mt-2">
                    <div class="col-md-3">
                        <label for="exam_type" class="form-label">Exam type</label>
                        <select name="exam_type" id="exam_type" class="form-control">
                            <option value="">Please Select</option>
                            <option value="MUET">MUET</option>
                            <option value="MOD">MOD</option>
                        </select>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>

    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                {{-- <button id="button-import-pos-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">IMPORT POS XLSX</button>
                                <button id="button-export-pos-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT POS XLSX</button>
                                <button id="button-export-xlsx" data-type="PROCESSING" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button> --}}
                            </div>
                            <div class="float-end my-3">
                                <button type="button" id="btnBulkConsignment" class="btn btn-soft-success waves-effect float-end mx-1">PRINT CONSIGNMENT NOTES</button>
                                <button type="button" id="btnBulkPrintProcessing" class="btn btn-soft-success waves-effect float-end ">PRINT CERTIFICATE</button>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            {{-- <div class="float-start my-3">
                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>
                            <div class="float-end my-3">
                                <button type="button" class="btn btn-soft-success waves-effect float-end ">PRINT CERTIFICATE</button>
                            </div> --}}
                            <div class="py-1">
                                <table id="posCompleteTable" data-type="COMPLETED" class="table w-100 table-striped text-center dt-responsive nowrap dataTable"
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
        @include('modules.admin.pos.completed.modal.updated')
    </div>

@endsection
@section('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {

            $('#button-export-xlsx').on('click', function (e) {

                e.preventDefault();
                window.location.href = 'pos-completed/export-xlsx';

            })

            $('#button-print-certificate-pdf').on('click', function (e) {

                e.preventDefault();
                window.location.href = 'pos-processing/print-certificate-pdf';

            })

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
    <script src="{{ asset('build/js/datatables/pos-completed.js') }}"></script> --}}

@endsection


@extends('layouts.master-mpm')
@section('title')
    Transaction
@endsection
@section('css')

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

    <div class="row mx-1">
        <div class="card rounded-0 bg-white border-top px-2">
            <div class="p-4">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start-date" class="form-label">Start Date:</label>
                        <input type="date" id="start-date-trx" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-3">
                        <label for="end-date" class="form-label">End Date:</label>
                        <input type="date" id="end-date-trx" class="form-control datepicker" placeholder="DD-MM-YYYY" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="text-search" class="form-label">Search:</label>
                        <input type="text" id="text-search-trx" class="form-control" placeholder="Enter text">
                    </div>
                    <div class="col-md-3" style="align-content: end;">
                            <button id="filterBtnTrx" class="btn btn-primary">Filter</button>
                            <button id="resetBtnTrx" class="btn btn-secondary">Reset</button>
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
                            {{-- <div class="float-start my-3">
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end">EXPORT XLSX</button>
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT PDF</button>
                            </div> --}}

                            <div class="py-4">

                                <table id="transactionTable" class="table table-sm w-100 table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">DATE</th>
                                        <th scope="col">TRANSACTION ID</th>
                                        <th scope="col">REFERENCE ID</th>
                                        <th scope="col">DETAILS</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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

@endsection
@section('script')

    <!-- DataTables Buttons JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

    {{-- <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>
    <script src="{{ asset('build/js/datatables/report-transaction.js') }}"></script> --}}

@endsection

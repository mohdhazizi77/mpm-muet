@extends('layouts.master-mpm')
@section('title')
    List Candidates
@endsection
@section('css')
    {{-- <!-- DataTables --> --}}

    {{-- <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme --> --}}
    <style>
        .dt-search {
            display: block; /* Ensure it's visible */
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            Manage Candidates
        @endslot
    @endcomponent

    @if (session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card-label">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-2" style="text-align: left; padding-top: 10px">
                                    <h4>List Candidates</h4>
                                </div>
                                <div class="col-md-4 col-sm-12 mt-2" style="text-align: right">
                                    {{-- <button class="btn btn-soft-success waves-effect float-end" id="show_create_modal">NEW USER</button> --}}
                                    <input type="text" class="form-control" id="search_term" placeholder="Search term">

                                </div>
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-success waves-effect " id="searchBtn">Search</button>
                                    <button class="btn btn-info waves-effect " id="resetBtn">Reset</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="py-2">

                                {{-- <table id="dt-user" class="table w-100 table-striped text-center dt-responsive nowrap dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="dt-candidate" class="table table-sm table-striped text-center" style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th width=5%>NO.</th>
                                            <th width=40%>NAME</th>
                                            <th width=40%>NRIC</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!--end col-->

            {{-- @include('modules.admin.administration.users.modal.create') --}}
            @include('modules.admin.administration.manage-candidates.modal.edit')
        </div>
    </div>

    @endsection
    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if the success message exists
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    // Hide the success message after 5 seconds
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                }
            });
        </script>
    @endsection

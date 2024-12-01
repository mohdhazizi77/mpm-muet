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

    {{-- <div class="container"> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n2 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    {{-- <h3 class="fw-bold fs-15">CANDIDATE'S DETAILS</h3> --}}
                                    <div style="overflow-x:auto;">
                                        <table class="table-borderless fs-14 mt-2 fw-bold">
                                            <tr>
                                                <td width=40%>NAME</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $candidate->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width=40%>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $candidate->identity_card_number }}</td>
                                            </tr>
                                        </table>
                                    </div>
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

        <div class="row py-4">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-12 align-self-center">
                                <div class="py-4">
                                    <table id="listCertTable" class="table w-100 table-striped dt-responsive nowrap dataTable fs-14"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <input type="hidden" id="candidate_id" value="{{ $candidate->id }}">
                                    {{-- <table id="candidatesTable"> --}}
                                        <thead>
                                            <tr class="text-center bg-dark-subtle">
                                                <th scope="col">#</th>
                                                <th scope="col">TYPE</th>
                                                <th scope="col">SESSION AND YEAR</th>
                                                <th scope="col">BAND OBTAINED</th>
                                                <th scope="col">INDEX NUMBER</th>
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

        <a href="{{ route('admin.candidate.index') }}" class="btn btn-soft-dark btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start">
            <i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i>
            Back
        </a>
    {{-- </div> --}}
    @include('modules.admin.administration.manage-candidates.modal.edit')

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

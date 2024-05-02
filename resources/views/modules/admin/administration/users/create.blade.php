@extends('layouts.master-mpm')
@section('title')
    Administration
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
            Administration
        @endslot
        @slot('title')
            Users
        @endslot
    @endcomponent

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <form action="" autocomplete="off">

                        <div class="row py-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off">
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="phonenumber" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phonenumber" name="phonenumber" autocomplete="off">
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <!-- Base Radios -->
                                <label for="role" class="form-label">Role</label>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">ADMINISTRATOR</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">PSM</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">BPKOM</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">KEWANGAN</label>
                                </div>


                            </div><!--end col-->

                        </div><!--end row-->

                    </form>

                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                {{--                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>--}}
                            </div>
                            <div class="float-end my-3">
                                <a href="{{ route('users.create') }}" class="btn btn-soft-success waves-effect float-end">REGISTER</a>
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
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <script>


                $(document).ready(function () {

                    $('#button-export-xlsx').on('click', function (e) {

                        e.preventDefault();
                        window.location.href = 'pos-new/export-xlsx';

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

@endsection


@extends('layouts.master-mpm')
@section('title')
    Reporting (Finance - MOD)
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
            Finance - Financial Statement
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
                                    <label class="form-label mb-3">Year</label>
                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected value="2022">-PLEASE SELECT-</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="mt-3">
                                <!-- Soft Buttons -->
                                <button type="button" class="btn btn-soft-primary waves-effect waves-light material-shadow-none">Search</button>
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

                            <div class="py-4">
                                {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                <!-- Striped Rows -->
                                <table class="table table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col" class="col-1">NO.</th>
                                        <th scope="col">TRANSACTION DATE</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="align-middle">
                                        <th scope="row">1</th>
                                        <td>31 JANUARY, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">2</th>
                                        <td>28 FEBRUARY, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">3</th>
                                        <td>31 MARCH, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">4</th>
                                        <td>30 APRIL, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">5</th>
                                        <td>31 MAY, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">6</th>
                                        <td>30 JUNE, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">7</th>
                                        <td>31 JULY, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">8</th>
                                        <td>31 AUGUST, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">9</th>
                                        <td>30 SEPTEMBER, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">10</th>
                                        <td>31 OCTOBER, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">11</th>
                                        <td>30 NOVEMBER, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">12</th>
                                        <td>31 DECEMBER, 2023</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>
                                                DOWNLOAD
                                            </button>
                                        </td>
                                    </tr>
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

@endsection


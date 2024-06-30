@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')


@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            POS Management
        @endslot
        @slot('title')
            New
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
                        <input type="date" id="end-date" class="form-control datepicker" placeholder="DD-MM-YYYY" >
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
            </div>
        </div>
    </div>

    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start my-3">
                                <button id="btnExportExcel" data-type="NEW" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>
                            <div class="float-end my-3">
                                <button type="button" id="btnBulkApprove" class="btn btn-soft-success waves-effect float-end ">APPROVE</button>
                                <button type="button" id="btnBulkCancel" class="btn btn-soft-warning waves-effect float-end mx-1 ">CANCEL</button>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">

                            <div class="py-1">
                                <table id="posNewTable" data-type="NEW" class="table w-100 table-striped text-center dt-responsive nowrap dataTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle ">
                                        <th width=5% scope="col"><input type="checkbox" class="form-check-input row-checkbox check-all"></th>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">DATE</th>
                                        <th scope="col">REFERENCE ID</th>
                                        <th scope="col">DETAILS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                {{--MODAL UPDATE POS--}}
                                <div id="modalUpdatePos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                                <div class="row mx-3">
                                                    <div class="col-xl-12">
                                                        <div class="row pt-3">
                                                            <div class="col-lg-12">
                                                                <div class="card rounded-0 bg-white mx-n4 border-top">

                                                                    <div class="card-header bg-dark-subtle">
                                                                        <div class="row">
                                                                            <div class="col-6">
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
                                                                                            <div class="col-6">
                                                                                                <div class="mb-3">
                                                                                                    <label for="name" class="form-label">Name</label>
                                                                                                    <input readonly type="text" class="form-control" placeholder="Enter your name" id="name" disabled value="">
                                                                                                </div>
                                                                                            </div><!--end col-->
                                                                                            <div class="col-6">
                                                                                                <div class="mb-3">
                                                                                                    <label for="icNumber" class="form-label">Identification Card Number</label>
                                                                                                    <input readonly type="text" class="form-control" placeholder="Enter your identification card number" disabled id="nric" value="">
                                                                                                </div>
                                                                                            </div><!--end col-->
                                                                                        </div><!--end row-->

                                                                                        {{-- <div class="row">
                                                                                            <div class="col-6">
                                                                                                <label class="form-label">Phone Number</label>
                                                                                                <div class="input-group" data-input-flag>
                                                                                                    <button readonly class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                                                            src="{{URL::asset('build/images/flags/my.svg')}}"
                                                                                                            alt="flag img" height="20"
                                                                                                            class="country-flagimg rounded"><span
                                                                                                            class="ms-2 country-codeno">+60</span></button>
                                                                                                    <input readonly type="text" class="form-control rounded-end flag-input" value="" placeholder="Enter your phone number" id="phone_num"
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
                                                                                                    <input readonly type="text" class="form-control" placeholder="Enter your email" id="email" value="">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> --}}

                                                                                        {{-- <div class="row">

                                                                                            <div class="col-12">
                                                                                                <div class="mb-3">
                                                                                                    <label for="address" class="form-label">Address</label>
                                                                                                    <input readonly type="text" class="form-control" placeholder="Enter your address" disabled id="address" value="">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div> --}}

                                                                                        {{-- <div class="row">
                                                                                            <div class="col-4">
                                                                                                <div class="mb-3">
                                                                                                    <label for="postcode" class="form-label">Postcode</label>
                                                                                                    <input readonly  type="text" class="form-control" placeholder="Enter your postcode" disabled id="postcode" value="">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-4">
                                                                                                <div class="mb-3">
                                                                                                    <label for="city" class="form-label">City</label>
                                                                                                    <input readonly  type="text" class="form-control" placeholder="Enter your city" disabled id="city" value="">
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

                                                <div class="modal-footer ">
                                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium float-start" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>Close</a>
                                                    <button type="button" class="btn btn-outline-warning float-end btn-cancel-pos">Cancel</button>
                                                    <button type="button" class="btn btn-outline-success float-end btn-approve-new">Approve</button>
                                                </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
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

@endsection


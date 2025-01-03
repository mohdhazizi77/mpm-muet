@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n2 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold fs-15">CANDIDATE'S DETAILS</h3>
                                    <div style="overflow-x:auto;">
                                        <table class="table-borderless fs-14 mt-2 fw-bold">
                                            <tr>
                                                <td width=40%>NAME</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width=40%>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->identity_card_number }}</td>
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
                                    <table id="candidatesTable" class="table w-100 table-striped dt-responsive nowrap dataTable fs-14"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    {{-- <table id="candidatesTable"> --}}
                                        <thead>
                                            <tr class="text-center bg-dark-subtle">
                                                <th scope="col">#</th>
                                                <th scope="col">TYPE</th>
                                                <th scope="col">SESSION AND YEAR</th>
                                                <th scope="col">BAND OBTAINED</th>
                                                <th scope="col">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <!-- MODAL VERIFY MPM -->
                                    <div id="modalVerifyMPM" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3 bg-dark-subtle">
                                                    <h4 class="card-title mb-0">Index Number Verification</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-5">
                                                            <label for="indexNumber" class="form-label">Index Number</label>
                                                            {{-- <label for="indexNumber" class="form-label">Index Number</label> --}}
                                                            <input type="text" class="form-control mb-2" id="indexNumber" placeholder="e.g. MD0000/0001" oninput="this.value = this.value.toUpperCase()">
                                                            <a class="text-decoration-none text-black-50 btnForgotIndexNumber">Forgot Index Number?</a>
                                                        </div>
                                                        <div class="clearfix">
                                                            <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                            <a data-type="MPM_PRINT" id="verifyIndexNumber" class="btn btn-success btn-animation waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL PAYMENT -->
                                    <div id="modalPayment" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3 bg-dark-subtle">
                                                    <h4 class="card-title mb-0">Payment required!</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label class="" style="font-weight: 400">In order to view and print this certificate, you must pay <b>RM{{ number_format($config->rate_selfprint, 2) }}</b> to unlock this certificate.</label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="" style="font-weight: 400">All certificates can be viewed and print within <b>48 hours</b> upon unlocked. You are advised to save the certificate in PDF format once your certificate is unlocked.</label>
                                                        </div>
                                                        <div class="text-end">
                                                            <a href="#" class="btn btn-success btn-animation waves-effect waves-light" data-text="Agree and Proceed to Payment"><span>Agree and Proceed to Payment</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL PAYMENT MPM -->
                                    <div id="modalPaymentMpm" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3 bg-dark-subtle">
                                                    <h4 class="card-title mb-0">Printing by MPM</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label class="" style="font-weight: 400">For every certificate printed by MPM, you will be charged RM60 <b> inclusive delivery charges. </b></label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="" style="font-weight: 400">All certificate will be processed and shipped within <b>2 working days</b>.  You are advised to save the certificate in PDF format once your certificate is unlocked.</label>
                                                        </div>
                                                        <div class="text-end">
                                                            <a href="#" class="btn btn-success btn-animation waves-effect waves-light" data-text="Agree and Order"><span>Agree and Order</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
    </div>
@endsection
@section('script')

{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

{{-- <script src="{{ asset('build/js/datatables/pos-new.js') }}"></script> --}}

<!-- DataTables CSS -->
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"> --}}
<!-- Responsive extension CSS -->
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.1/css/responsive.dataTables.min.css"> --}}

<!-- jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<!-- DataTables JS -->
{{-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> --}}
<!-- Responsive extension JS -->
{{-- <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.1/js/dataTables.responsive.min.js"></script> --}}

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<!-- RowReorder JS -->
<script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
<!-- Responsive extension JS -->
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>


@endsection

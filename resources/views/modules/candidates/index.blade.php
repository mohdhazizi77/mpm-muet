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
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold">CANDIDATE'S DETAILS</h3>
                                    <table class="table-borderless fs-16 mt-3 fw-bold">
                                        <tr>
                                            <td>NAME</td>
                                            <td class="px-2">:</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>IDENTIFICATION CARD NUMBER / PASSPORT</td>
                                            <td class="px-2">:</td>
                                            <td>{{ $user->identity_card_number }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            {{--                        <div class="col-xxl-3 ms-auto">--}}
                            {{--                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">--}}
                            {{--                                <img src="{{ URL::asset('build/images/faq-img.png') }}" alt="" class="img-fluid">--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
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
                                    {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                    <!-- Striped Rows -->
                                    <table id="candidatesTable" class="table table-striped text-center" >
                                        <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th scope="col">NO.</th>
                                            <th scope="col">SESSION AND YEAR</th>
                                            <th scope="col">RESULT</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    {{--MODAL VERIFY PDF--}}
                                    {{-- <div id="modalVerifyPDF" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
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
                                                            <input type="text" class="form-control mb-2" id="indexNumber">
                                                            <a class="text-decoration-none text-black-50" href="#">Forgot Index Number?</a>
                                                        </div>
                                                        <div class="clearfix">
                                                            <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                            <a data-type="SELF_PRINT" class="btn btn-soft-success waves-effect waves-light w-md float-end verifyIndexNumber" data-text="Verify"><span>Verify</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div> --}}

                                    {{--MODAL VERIFY MPM--}}
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
                                                            <input type="text" class="form-control mb-2" id="indexNumber">
                                                            <a class="text-decoration-none text-black-50 btnForgotIndexNumber">Forgot Index Number?</a>
                                                        </div>
                                                        <div class="clearfix">
                                                            <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                            {{-- <a href="{{ Route('candidate.printmpm', ['id' => 41]) }}" class="btn btn-success btn-animation waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a> --}}
                                                            <a data-type="MPM_PRINT" id="verifyIndexNumber" class="btn btn-success btn-animation waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    {{--MODAL PAYMENT--}}
                                    <div id="modalPayment" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3 bg-dark-subtle">
                                                    <h4 class="card-title mb-0">Payment</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label class="form-label">Candidate must pay RM20 to print MUET certificate</label>
                                                        </div>
                                                        <div class="text-end">
                                                            <a href="#" class="btn btn-success btn-animation waves-effect waves-light" data-text="Continue"><span>Continue</span></a>
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

@endsection

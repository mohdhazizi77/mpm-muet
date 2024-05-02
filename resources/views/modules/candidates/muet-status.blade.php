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

                {{-- @if($status != 0) --}}
                @if(true)
                    <div class="card rounded-0 {{ $status == 'SUCCESS' ? 'bg-success-subtle' : 'bg-danger' }}  mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-6 align-self-center">
                                    <div class="py-3">
                                        <h3 class="fw-bold">PAYMENT {{ $status }}!</h3>
                                        <table class="table-borderless fs-16 mt-3">
                                            <tr>
                                                <td class="fw-bold">
                                                    TRANSACTION ID : {{ $txn_id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Your MUET certificate will be processed and sent according to the address given.</td>
                                            </tr>
                                            <tr>
                                                <td>An automated payment receipt will be sent to your email.</td>
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
                @endif
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
                                        <table class="table table-striped text-center">
                                            <thead>
                                            <tr class="text-center bg-dark-subtle">
                                                <th scope="col">NO.</th>
                                                <th scope="col">DATE AND TIME</th>
                                                <th scope="col">DESCRIPTION</th>
                                                <th scope="col">STATUS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="align-middle">
                                                <th scope="row">1</th>
                                                <td>09/12/2023 12:30:00</td>
                                                <td></td>
                                                <td><h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5></td>
                                            </tr>
                                            <tr class="align-middle">
                                                <th scope="row">2</th>
                                                <td>10/12/2023 13:30:00</td>
                                                <td>Tracking Number : <a target="_blank" href="https://www.tracking.my/pos/ABC123">ABC123</a></td>
                                                <td><h5><span class="badge rounded-pill bg-success">COMPLETED</span></h5></td>
                                            </tr>

                                            </tbody>
                                        </table>

                                        {{--MODAL VERIFY PDF--}}
                                        <div id="modalVerifyPDF" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
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
                                                                <a href="{{ Route('candidates.printpdf') }}" class="btn btn-soft-success waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        {{--MODAL VERIFY MPMF--}}
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
                                                                <a class="text-decoration-none text-black-50" href="#">Forgot Index Number?</a>
                                                            </div>
                                                            <div class="clearfix">
                                                                <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                                <a href="{{ Route('candidates.printmpm') }}" class="btn btn-success btn-animation waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
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
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                    </div>
                                </div>
                                {{--                        <div class="col-xxl-3 ms-auto">--}}
                                {{--                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">--}}
                                {{--                                <img src="{{ asset('build/images/faq-img.png') }}" alt="" class="img-fluid">--}}
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

            <div>

                <x-button.back></x-button.back>
                {{--                <a id="button-download" href="{{ route('candidates.downloadpdf') }}" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">--}}
                {{--                    <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i>DOWNLOAD--}}
                {{--                </a>--}}
            </div>


        </div>
        @endsection
        @section('script')

            <script>

                $(document).ready(function () {

                    $('#button-download').on('click', function (e) {

                        e.preventDefault();

                        // let selectedState = $('#state').val();
                        // let selectedType = $('#type').val();
                        // let selectedCollege = $('#collegeAll').val();
                        // let selectedYear = $('#year').val();
                        // let selectedSemester = $('#semester').val();
                        // let selectedCourse = $('#courseAll').val();

                        let action = $(this).attr('href')
                        // let url = action + '?state=' + selectedState +
                        //     '&type=' + selectedType +
                        //     '&college=' + selectedCollege +
                        //     '&year=' + selectedYear +
                        //     '&semester=' + selectedSemester +
                        //     '&course=' + selectedCourse;

                        let url = action;
                        window.location.href = url;
                    })

                })

            </script>

@endsection

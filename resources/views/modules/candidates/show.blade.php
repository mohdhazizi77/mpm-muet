@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-success-subtle mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-6 align-self-center">
                            <div class="py-3">
                                <h3 class="fw-bold">asd DETAILS</h3>
                                <table class="table-borderless fs-16 mt-3 fw-bold">
                                    <tr>
                                        <td>NAME</td>
                                        <td class="px-2">:</td>
                                        <td>ALI BIN ABU</td>
                                    </tr>
                                    <tr>
                                        <td>IDENTIFICATION CARD NUMBER</td>
                                        <td class="px-2">:</td>
                                        <td>900101121357</td>
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
                                <table class="table table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">#</th>
                                        <th scope="col">SESSION AND YEAR</th>
                                        <th scope="col">RESULT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="align-middle">
                                        <th scope="row">1</th>
                                        <td>SESSION 3, 2023</td>
                                        <td>BAND 5</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">PRINT PDF</button>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">PRINT CERTIFICATE</button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">2</th>
                                        <td>SESSION 1, 2023</td>
                                        <td>BAND 4</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">PRINT PDF</button>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">PRINT CERTIFICATE</button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">3</th>
                                        <td>SESSION 2, 2021</td>
                                        <td>BAND 4</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">PRINT PDF</button>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">PRINT CERTIFICATE</button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <th scope="row">4</th>
                                        <td>SESSION 1, 2017</td>
                                        <td>BAND 3</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalPayment">PRINT PDF</button>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black" data-bs-toggle="modal" data-bs-target="#modalPayment">PRINT CERTIFICATE</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                {{--MODAL VERIFY PDF--}}
                                <div id="modalVerifyPDF" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3 bg-dark-subtle">
                                                <h4 class="card-title mb-0">Student ID Verification</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="mb-3">
                                                        <label for="angkaGiliran" class="form-label">Student ID</label>
                                                        <input type="text" class="form-control" id="angkaGiliran">
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="{{ Route('candidate.show', Crypt::encrypt(2023) ) }}" class="btn btn-success btn-animation waves-effect waves-light" data-text="Verify"><span>Verify</span></a>
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
                                                <h4 class="card-title mb-0">Student ID Verification</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="mb-3">
                                                        <label for="angkaGiliran" class="form-label">Student ID</label>
                                                        <input type="text" class="form-control" id="angkaGiliran">
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="#" class="btn btn-success btn-animation waves-effect waves-light" data-text="Verify"><span>Verify</span></a>
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
@endsection
@section('script')



@endsection

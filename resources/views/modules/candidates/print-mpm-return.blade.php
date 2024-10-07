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
                <div class="card rounded-0 {{ $status == 'SUCCESS' ? 'bg-success-subtle' : 'bg-warning' }}  mx-n4 mt-n4 border-top">

                    <div class="p-4">
                        <div class="row1">
                            @if($status == 'SUCCESS')
                            <h3 class="fw-bold">We have received your payment!</h3>
                            @else
                            <h3 class="fw-bold">Payment Failed!</h3>
                            @endif
                            {{-- <h3 class="fw-bold">PAYMENT {{ $status }}!</h3> --}}
                            <table class="table-borderless fs-16 mt-3" width="100%">
                                <tr>
                                    <td class="fw-bold" style="text-align: left;">
                                        PAYMENT REFERENCE: {{ $txn_id }}<br>
                                    </td>
                                    <td class="fw-bold"  style="text-align: right;">
                                        TRANSACTION REFERENCE: {{ $order->unique_order_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">
                                        @if($status == 'SUCCESS')
                                        Your certificate will be processed and will be shipped
                                        according to the shipping information given. An
                                        automated payment receipt will be sent to your
                                        email.
                                        <br>
                                        If you have not received your order after seven (7) working days, kindly email us at
                                        <a href="mailto:sijil@mpm.edu.my?subject=Order%20Inquiry&body=Please%20attach%20your%20transaction%20reference%20and%20payment%20receipt.">sijil@mpm.edu.my</a> and attach your transaction reference and payment receipt.

                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <!-- end card body -->
                </div>
            </div>

            <div class="row py-4">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-12 align-self-center">
                                    <div class="py-4">

                                        {{-- <table class="table table-striped text-center"> --}}
                                        <table  class="display responsive nowrap" style="width:100%">
                                            <thead>
                                            <tr class="text-center bg-dark-subtle">
                                                <th scope="col">NO.</th>
                                                <th scope="col">DATE RECEIVED</th>
                                                <th scope="col">DESCRIPTION</th>
                                                <th scope="col">STATUS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="align-middle">
                                                <th scope="row">1</th>
                                                <td>{{ $order->created_at->format('d/m/y H:i:s') }}</td>
                                                <td>@if($status == 'SUCCESS') Paid @else Failed @endif</td>
                                                <td><h5><span class="badge rounded-pill bg-info">{{ $order->payment_status }}</span></h5></td>
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

            <div>

                {{-- <x-button.back></x-button.back> --}}
                <a href="{{ route('candidate.index') }}" class="btn btn-soft-dark btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i>BACK TO HOME</a>

                {{--                <a id="button-download" href="{{ route('candidate.downloadpdf') }}" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">--}}
                {{--                    <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i>DOWNLOAD--}}
                {{--                </a>--}}
            </div>

        </div>
    </div>
@endsection
@section('script')
    <!-- RowReorder JS -->
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
    <!-- Responsive extension JS -->
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>

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

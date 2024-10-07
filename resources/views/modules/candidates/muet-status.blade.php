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
                @php
                    if($payment->status == "SUCCESS")
                        $status = 'success-subtle';
                    elseif($payment->status == "PENDING")
                        $status = 'warning-subtle';
                    else
                        $status = 'danger-subtle';
                @endphp

                    <div class="card rounded-0 bg-{{ $status }} border-top ">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-12 align-self-center">
                                    <div class="py-3">
                                        <h3 class="fw-bold">PAYMENT {{ $payment->status }}!</h3>
                                        <table class="table w-100 table-borderless fs-14 mt-3">
                                            <tr>
                                                {{-- <td class="fw-bold"> TRANSACTION REFERENCE ID : {{ empty($payment->txn_id) ? '' : $payment->txn_id }} </td> --}}
                                                <td class="fw-bold p-0"> TRANSACTION <br class="d-md-none"> REFERENCE ID : <br class="d-md-none"> {{ empty($order->unique_order_id) ? '' : $order->unique_order_id }} </td>
                                                <td class="fw-bold p-0" style="text-align: end"> PAYMENT <br class="d-md-none"> REFERENCE ID  : <br class="d-md-none"> {{ empty($payment->ref_no) ? $order->payment_ref_no : $payment->txn_id }}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                           {{-- <tr>
                                                <td></td>
                                                <td class="fw-bold">
                                                    RECEIPT NUMBER  : {{ $payment->receipt_number }}
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <td colspan="2">Your MUET certificate are processing and sent according to the given address.</td>
                                            </tr> --}}
                                            @if ($payment->status == "SUCCESS")
                                                <tr>
                                                    <td class="p-0" colspan="2">An automated payment receipt already sent to your email. If not received payment receipt, click <a href="{{ $payment->receipt }}" target="_blank">here</a> </td>
                                                </tr>
                                            @elseif($payment->status == "PENDING")
                                                <tr>
                                                    <td class="p-0" colspan="2">Retry make payment <a href="https://ebayar-lab.mpm.edu.my/payments/{{ $order->payment_ref_no }}/gateway" target="_blank">here</a> </td>
                                                </tr>
                                            @elseif($payment->status == "FAILED")

                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
            </div>
        </div>

        @if ($order->payment_for == "MPM_PRINT")
            <div class="row">
                <div class="col-lg-6">
                    <div class="card rounded-0 bg-white border-top p-4">
                        <h5 class="">CERTIFICATE ORDER HISTORY</h5>
                        <table id="trackOrderTable" data-id="{{ $cryptId }}"
                         {{-- class="table table-striped text-center" --}}
                         class="display responsive nowrap" style="width:100%"

                         >
                            <thead>
                            <tr class="text-center bg-dark-subtle fs-12">
                                <th scope="col">#</th>
                                <th scope="col">DATE UPDATED</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{-- <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-12 align-self-center">
                                    <div class="py-4">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <div class="col-lg-6">
                    <div class="card rounded-0 bg-white border-top p-4">
                        <h5 class="">TRACK ORDER</h5>
                        <label for="" class="my-3">TRACKING NUMBER : {{ !empty($order->tracking_number) ? $order->tracking_number : '-' }}</label>
                        <table id="trackShippingTable" data-id="{{ $cryptId }}" data-trackno="{{ $order->tracking_number }}"
                            {{-- class="table table-striped text-center" --}}
                            class="display responsive nowrap" style="width:100%"
                            >
                            <thead>
                                <tr class="text-center bg-dark-subtle">
                                    <th scope="col">#</th>
                                    <th scope="col">DATE AND TIME</th>
                                    <th scope="col">DETAIL</th>
                                    {{-- <th scope="col">STATUS</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        @else {{-- SELF_PRINT --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-white border-top p-4">
                        <h4 class="">CERTIFICATE ORDER HISTORY</h4>
                        <table id="trackOrderTable" data-id="{{ $cryptId }}" class="table table-striped text-center">
                            <thead>
                            <tr class="text-center bg-dark-subtle">
                                <th scope="col">#</th>
                                <th scope="col">DATE AND TIME</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{-- <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-12 align-self-center">
                                    <div class="py-4">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        @endif

        <div>
            <a href="{{ url()->previous() }}" class="btn btn-soft-dark btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start">
                <i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i>BACK TO ORDER HISTORY
            </a>
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

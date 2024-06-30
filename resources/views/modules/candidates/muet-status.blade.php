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
                    if($order->payment_status == "SUCCESS")
                        $status = 'success-subtle';
                    elseif($order->payment_status == "PENDING")
                        $status = 'warning-subtle';
                    else
                        $status = 'danger-subtle';
                @endphp

                    <div class="card rounded-0 bg-{{ $status }} border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-12 align-self-center">
                                    <div class="py-3">
                                        <h3 class="fw-bold">PAYMENT {{ $order->payment_status }}!</h3>
                                        <table class="table w-100 table-borderless fs-16 mt-3">
                                            <tr>
                                                {{-- <td class="fw-bold"> TRANSACTION REFERENCE ID : {{ empty($payment->txn_id) ? '' : $payment->txn_id }} </td> --}}
                                                <td class="fw-bold"> TRANSACTION REFERENCE ID : {{ empty($order->unique_order_id) ? '' : $order->unique_order_id }} </td>
                                                <td class="fw-bold" style="text-align: end"> PAYMENT REFERENCE ID  : {{ empty($payment->ref_no) ? $order->payment_ref_no : $payment->ref_no }}</td>
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
                                            @if (!empty($payment->ref_no))
                                            <tr>
                                                <td colspan="2">An automated payment receipt already sent to your email. If not received payment receipt, click <a href="{{ $payment->receipt }}" target="_blank">here</a> </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td colspan="2">Retry make payment <a href="https://ebayar-lab.mpm.edu.my/payments/{{ $order->payment_ref_no }}/gateway" target="_blank">here</a> </td>
                                            </tr>
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
                        <h4 class="">CERTIFICATE ORDER HISTORY</h4>
                        <table id="trackOrderTable" data-id="{{ $cryptId }}" class="table table-striped text-center">
                            <thead>
                            <tr class="text-center bg-dark-subtle">
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
                        <h4 class="">TRACK ORDER</h4>
                        <label for="" class="my-3">TRACKING NUMBER : {{ $order->tracking_number }}</label>
                        <table id="trackShippingTable" data-id="{{ $cryptId }}" class="table table-striped text-center">
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
            <a href="javascript:history.go(-1)" class="btn btn-soft-dark btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start">
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

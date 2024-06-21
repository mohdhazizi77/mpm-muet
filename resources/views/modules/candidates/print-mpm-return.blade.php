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
                <div class="card rounded-0 {{ $status == 'SUCCESS' ? 'bg-success-subtle' : 'bg-danger' }}  mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold">PAYMENT {{ $status }}!</h3>
                                    <table class="table-borderless fs-16 mt-3">
                                        <tr>
                                            <td class="fw-bold">
                                                REFERENCE ID: {{ $order->unique_order_id }}
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
                                                <td>{{ $order->created_at->format('d/m/y H:i:s') }}</td>
                                                <td>User had  make payment</td>
                                                <td><h5><span class="badge rounded-pill bg-info">{{ $order->current_status }}</span></h5></td>
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

                <x-button.back></x-button.back>
                {{--                <a id="button-download" href="{{ route('candidate.downloadpdf') }}" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">--}}
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

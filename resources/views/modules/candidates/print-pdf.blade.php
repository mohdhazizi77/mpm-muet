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
                                            <td>IDENTIFICATION CARD NUMBER</td>
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

        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="py-4">
                                    {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                    <!-- Striped Rows -->
                                    <table class="table table-borderless text-center">
                                        <div class="clearfix">
                                            <h4 class="py-2 fw-bold float-start">{{ $result['session'] }}</h4>
                                            <h4 class="py-2 fw-bold float-end">{{ $result['index_number'] }}</h4>
                                        </div>
                                        <thead>
                                        <tr class="text-center bg-dark-subtle border-1 border-black">
                                            <th scope="col" class="w-25 border-1 border-black">TEST COMPONENT</th>
                                            <th scope="col" class="w-25 border-1 border-black">MAXIMUM SCORE</th>
                                            <th scope="col" class="w-25 border-1 border-black">OBTAINED SCORE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="align-middle ">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">LISTENING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['listening'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['listening'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">SPEAKING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['speaking'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['speaking'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">READING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['reading'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['reading'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">WRITING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['writing'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['writing'] }}</td>
                                        </tr>
                                        <tr class="align-middle fw-bold">
                                            <td class="border-black border-1">AGGREGATED SCORE</td>
                                            <td class="border-black border-1">{{ $scheme['agg_score'] }}</td>
                                            <td class="border-black border-1">{{ $result['agg_score'] }}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-borderless text-center">
                                        <tbody>
                                        <tr class="align-middle fw-bold pt-3">
                                            <td class="w-25 hidden"></td>
                                            <td class="w-25 text-end">BAND ACHIEVED</td>
                                            <td class="w-25 bg-dark-subtle border-1 border-black">{{ $result['band'] }}</td>
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
            <a id="button-download"  href="{{ route('candidate.downloadpdf', ['id' => $cryptId]) }}" target="_blank" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">
                <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i>DOWNLOAD
            </a>
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

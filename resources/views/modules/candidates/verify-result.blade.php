@extends('layouts.master-qr-nav')
@section('title')
    MUET Online Certificate
@endsection

@section('css')
    <style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 767px) {
            .content-wrap {
                margin-top: 10px;
            }
        }
    </style>
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
                                    <div style="overflow-x:auto;">
                                        <table class="table-borderless fs-16 mt-3 fw-bold">
                                            <tr>
                                                <td>NAME</td>
                                                <td class="px-2">:</td>
                                                <td class="d-none d-xxl-table-cell">{{ $candidate->nama }}</td>
                                            </tr>
                                            <tr class="d-xxl-none">
                                                <td colspan="3">
                                                    {{ $candidate->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="d-none d-xxl-table-cell">{{ $candidate->kp }}</td>
                                            </tr>
                                            <tr class="d-xxl-none">
                                                <td colspan="3">
                                                     {{ $candidate->kp }}
                                                </td>
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
        

        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="py-4">
                                    {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                    <!-- Striped Rows -->
                                    <div style="overflow-x:auto;">
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
                                    </div>

                                    <table class="table table-borderless text-center content-wrap">
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

    </div>
@endsection
@section('script')

    <script>

    </script>

@endsection

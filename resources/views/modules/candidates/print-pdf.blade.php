@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')

@endsection

@section('content')
    <div class="container">
        {{-- <div class="row">
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
                                                <td class="d-none d-xxl-table-cell">{{ $user->name }}</td>
                                            </tr>
                                            <tr class="d-xxl-none">
                                                <td colspan="3">
                                                    {{ $user->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="d-none d-xxl-table-cell">{{ $user->identity_card_number }}</td>
                                            </tr>
                                            <tr class="d-xxl-none">
                                                <td colspan="3">
                                                     {{ $user->identity_card_number }}
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
        </div> --}}

        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n2 border-top">
                    <div class="px-4">
                        <div class="row">
                            @if(Session::has('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold fs-15">CANDIDATE'S DETAILS</h3>
                                    <div style="overflow-x:auto;">
                                        <table class="table-borderless fs-14 mt-2 fw-bold">
                                            <tr>
                                                <td width=40%>NAME</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td width=40%>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->kp }}</td>
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
                                    <table class="table table-borderless text-center">
                                        <div class="clearfix">
                                            <h5 class="py-2 fw-bold float-start">{{ $result['session'] }}</h5>
                                            <h5 class="py-2 fw-bold float-end">{{ $result['index_number'] }}</h5>
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
            {{-- <a href="{{ url()->previous() }}" class="btn btn-soft-dark btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start">
                <i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i>
                Back
            </a> --}}
            <a id="button-download"  data-download-url="{{ route('candidate.downloadpdf', ['id' => $cryptId]) }}" target="_blank" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">
                <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i>DOWNLOAD
            </a>
        </div>

        <form id="downloadForm" action="" method="GET" target="_blank" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
@section('script')

    <script>

        $(document).ready(function () {
            $('#button-download').on('click', function (e) {

                var downloadUrl = $(this).data('download-url');

                $.ajax({
                    url: '{{ route('log.download') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: '{{ $cryptId }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Set the action attribute of the form to the download URL
                            $('#downloadForm').attr('action', downloadUrl);
                            // Submit the form, which will open the download in a new tab
                            $('#downloadForm').submit();
                        } else {
                            alert('Failed to log download activity.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while logging download activity.');
                    }
                });
            })

        })

    </script>

@endsection

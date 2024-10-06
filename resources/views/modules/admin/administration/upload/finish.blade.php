@extends('layouts.master-mpm')
@section('title')
Upload Candidates Muet & MOD
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('css')
    {{-- <!-- DataTables --> --}}

    <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme -->
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            View Candidates Muet & MOD
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class="live-preview">

                        <table id="datatableViewExcel" class="table table-bordered dt-responsive fs-6 nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>TAHUN</th>
                                <th>SESI</th>
                                <th>NAMASESI</th>
                                <th>NAMA</th>
                                <th>KP</th>
                                <th>ANGKA GILIRAN</th>
                                <th>TARIKH ISU</th>
                                <th>TARIKH EXP</th>
                                <th>SKOR</th>
                                {{-- <th>LISTENING</th>
                                <th>SPEAKING</th>
                                <th>READING</th>
                                <th>WRITING</th>
                                <th>SKOR_AGG</th>
                                <th>BAND</th> --}}
                                <th>STATUS</th>
                                <th>REMARK</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($processArray as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value[0] ?? '-' }}</td>
                                    <td>{{ $value[1] ?? '-' }}</td>
                                    <td>{{ $value[2] ?? '-' }}</td>
                                    <td>{{ $value[3] ?? '-' }}</td>
                                    <td>{{ $value[4] ?? '-' }}</td>
                                    <td>{{ $value[5] ?? '-' }}</td>
                                    <td>{{ $value[6] ?? '-' }}</td>
                                    <td>{{ $value[7] ?? '-' }}</td>
                                    <td>
                                        LISTENING : {{ $value[8] ?? '-' }}<br>
                                        SPEAKING : {{ $value[9] ?? '-' }}<br>
                                        READING : {{ $value[10] ?? '-' }}<br>
                                        WRITING : {{ $value[11] ?? '-' }}<br>
                                        SKOR_AGG : {{ $value[12] ?? '-' }}<br>
                                        BAND : {{ $value[13] ?? '-' }}<br>
                                    </td>
                                    {{-- <td>{{ $value[8] ?? '-' }}</td>
                                    <td>{{ $value[9] ?? '-' }}</td>
                                    <td>{{ $value[10] ?? '-' }}</td>
                                    <td>{{ $value[11] ?? '-' }}</td>
                                    <td>{{ $value[12] ?? '-' }}</td>
                                    <td>{{ $value[13] ?? '-' }}</td> --}}
                                    <td class="text-center">{!! $value[14] ? '<i class="ri-check-line me-1 align-middle" style="color:green"></i>' : '<i class="ri-close-line me-1 align-middle" style="color:red"></i>' !!}</td>
                                    <td>{!! nl2br(e($value[15])) !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="row m-0 p-0 pt-5">
            <div class="text-end">
                <a href="{{ route('upload.index') }}" class="btn btn-success waves-effect waves-light w-md me-2">
                    <i class="dripicons-arrow-left me-1 align-middle"></i>
                    Kembali ke Muetnaik Excel
                </a>
            </div>
        </div>
    </div>
    <!--end row-->

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {
            // var startYear = 2000;
            // var currentDate = new Date();
            // var currentYear = currentDate.getFullYear();

            // $('#year-select').append('<option selected disabled>-PLEASE SELECT-</option>');
            // for (var year = startYear; year <= currentYear; year++) {
            //     $('#year-select').append('<option value="' + year + '">' + year + '</option>');
            // }

        });

        $(document).ready(function() {
            // Handle the Search button click
            $('#searchBtn').on('click', function() {

                // Gather the values from the dropdowns
                var year = $('#year-select').val();
                var session = $('#session-select').val();
                var type = $('#exam-type').val();


                // Validation check: ensure all dropdowns are selected
                if (!year || !session || !type) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Selection',
                        text: 'Please make sure all dropdowns are selected before searching.',
                        confirmButtonText: 'OK'
                    });
                    return; // Stop the function if validation fails
                }

                // Show SweetAlert loading popup
                Swal.fire({
                    title: 'Processing...',
                    // text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Perform the AJAX POST request
                $.ajax({
                    url: '/admin/pull-db/ajax',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        year: year,
                        session: session,
                        type: type
                    },
                    success: function(response) {
                        // On success, close the SweetAlert
                        Swal.close();
                        // You can also handle the response here if needed
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle errors if the request fails
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            });

            // /pull-db/ajax

            // Handle the Reset button click
            $('#resetBtn').on('click', function() {
                $('#year-select').val('');
                $('#session-select').val('');
                $('#exam-type').val('');
            });
        });


    </script>

    <!-- Required datatable js -->
    {{-- <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>

@endsection


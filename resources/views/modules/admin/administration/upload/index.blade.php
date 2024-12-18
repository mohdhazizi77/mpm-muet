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
            Upload Candidates Muet & MOD
        @endslot
    @endcomponent

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-2">
                    <div class="live-preview">

                        <div class="row gy-1">
                            {{-- <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">YEAR</label>
                                    <select id="year-select" class="form-select mb-3" aria-label="Default select example">
                                        <option selected disabled> -- PLEASE SELECT -- </option>
                                        @for ($i = 2000; $i < date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">SESSION</label>
                                    <select id="session-select" class="form-select mb-3" aria-label="Default select example">
                                        <option selected disabled> -- PLEASE SELECT -- </option>
                                        <option value="sesi1">1</option>
                                        <option value="sesi2">2</option>
                                        <option value="sesi3">3</option>
                                    </select>
                                </div>
                            </div> --}}

                            <form action="{{ route('upload.excel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-lg-2">
                                        <div class="mt-3">
                                            <label class="form-label mb-3">TYPE</label>
                                            <select id="exam-type" name="examType" class="form-select mb-3" required aria-label="Default select example">
                                                <option selected disabled> -- PLEASE SELECT -- </option>
                                                <option value="MUET">MUET</option>
                                                <option value="MOD">MOD</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="excelFile">Muatnaik Excel File:</label>
                                        <input type="file" name="excelFile" id="excelFile" class="form-control" accept=".xlsx,.xls" required>
                                    </div>
                                    <div class="col-md-2 pt-4">
                                        <button type="submit" class="btn btnUploadExcel btn-primary mt-3 mt-md-0">Muatnaik Excel</button>
                                        {{-- <a href="{{ asset('storage/borangPemeriksa/Contoh Excel Sheet Profil Pemeriksa.xlsx') }}" class="btn btn-warning mt-3 mt-md-0">Muat Turun Borang</a> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>

@endsection


@extends('layouts.master-mpm')
@section('title')
    Reporting (Finance - MOD)
@endsection
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
            Reporting
        @endslot
        @slot('title')
            Finance - Financial Statement
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">

                        <div class="row gy-1">
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">Year</label>
                                    <select id="year-select" class="form-select mb-3" aria-label="Default select example">
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="mt-3">
                                <!-- Soft Buttons -->
                                <button type="button" id="search" class="btn btn-soft-primary waves-effect waves-light material-shadow-none">Search</button>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

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
                                        <th scope="col" class="col-1">NO.</th>
                                        <th scope="col">TRANSACTION DATE</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dynamic-table-body">
                                        <!-- Rows will be appended here -->
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

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {
            // $("#basicDate").flatpickr(
            //     {
            //         mode: "range",
            //         dateFormat: "d-m-Y",
            //     }
            // );

            var startYear = 2022;
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();

            $('#year-select').append('<option selected disabled>-PLEASE SELECT-</option>');
            for (var year = startYear; year <= currentYear; year++) {
                $('#year-select').append('<option value="' + year + '">' + year + '</option>');
            }

            $('#search').on('click', function() {
                var selectedYear = $('#year-select').val();
                generateTableRows(selectedYear)
            });

            generateTableRows(currentYear);
            
            function generateTableRows(selectedYear) {
                $('#dynamic-table-body').empty();
                var startDate = new Date(selectedYear, 0, 1);
                var endDate = new Date(selectedYear, 11, 31); // End of selected year
                var counter = 1;

                // Ensure the startDate does not exceed currentDate
                while (startDate <= currentDate && startDate <= endDate) {
                    var day = getLastDayOfMonth(startDate.getMonth(), startDate.getFullYear());
                    var month = startDate.toLocaleString('default', { month: 'long' }).toUpperCase();
                    var year = startDate.getFullYear();
                    var formattedDate = day + ' ' + month + ', ' + year;

                    // Append row to the table body
                    $('#dynamic-table-body').append(
                        '<tr class="align-middle">' +
                            '<th scope="row">' + counter + '</th>' +
                            '<td>' + formattedDate + '</td>' +
                            '<td>' +
                                '<button type="button" class="btn btn-soft-info waves-effect text-black mx-2 download-button"data-year="' + year + '" data-month="' + (startDate.getMonth() + 1) + '">' +
                                    '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                    'DOWNLOAD' +
                                '</button>' +
                            '</td>' +
                        '</tr>'
                    );

                    // Move to the next month
                    startDate.setMonth(startDate.getMonth() + 1);
                    counter++;
                }

                $('.download-button').on('click', function() {
                    var year = $(this).data('year');
                    var month = $(this).data('month');

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    
                    $.ajax({
                        url: '{{ route('finance-statement.download_excel') }}',
                        method: 'POST',
                        data: { year: year, month: month },
                        xhrFields: {
                            responseType: 'blob' // Important for file download
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = 'report-' + year + '-' + month + '.xlsx';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        },
                        error: function() {
                            alert('Error generating the report.');
                        }
                    });
                });
            }

            function getLastDayOfMonth(month, year) {
                return new Date(year, month + 1, 0).getDate();
            }
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>

@endsection


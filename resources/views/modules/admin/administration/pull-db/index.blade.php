@extends('layouts.master-mpm')
@section('title')
Import Candidates DB Muet & MOD
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('css')
    {{-- <!-- DataTables --> --}}

    {{-- <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/> --}}
    {{-- <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/> --}}

    <!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css"/>
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme -->
    <style>
        .dt-search {
            display: block; /* Ensure it's visible */
        }
        td.text-left {
            text-align: left;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            Import Candidates DB - Muet & MOD
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.pullDB.post')}}" method="post">
                            @csrf
                        <div class="row gy-1">
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">EXAM TYPE</label>
                                    <select id="exam-type" class="form-select mb-3" aria-label="Default select example" name="type">
                                        <option selected disabled> -- PLEASE SELECT -- </option>
                                        <option value="MUET" @if('MUET' == $request->type) selected @endif>MUET</option>
                                        <option value="MOD" @if('MOD' == $request->type) selected @endif>MOD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">YEAR</label>
                                    <select id="year-select" class="form-select mb-3" aria-label="Default select example" name="year">
                                        <option selected disabled> -- PLEASE SELECT -- </option>
                                        @for ($i = date("Y"); $i >= 2015; $i--)
                                        <option value="{{ $i }}" @if($i == $request->year) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">SESSION</label>
                                    <select id="session-select" class="form-select mb-3" aria-label="Default select example" name="session">
                                        <option selected disabled> -- PLEASE SELECT -- </option>
                                        <option value="1" @if('1' == $request->session) selected @endif>January</option>
                                        <option value="2" @if('2' == $request->session) selected @endif>Febraury</option>
                                        <option value="3" @if('3' == $request->session) selected @endif>Mac</option>
                                        <option value="4" @if('4' == $request->session) selected @endif>April</option>
                                        <option value="5" @if('5' == $request->session) selected @endif>May</option>
                                        <option value="6" @if('6' == $request->session) selected @endif>June</option>
                                        <option value="7" @if('7' == $request->session) selected @endif>July</option>
                                        <option value="8" @if('8' == $request->session) selected @endif>August</option>
                                        <option value="9" @if('9' == $request->session) selected @endif>September</option>
                                        <option value="10" @if('10' == $request->session) selected @endif>October</option>
                                        <option value="11" @if('11' == $request->session) selected @endif>November</option>
                                        <option value="12" @if('12' == $request->session) selected @endif>December</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-3">
                                <div class="mt-5">
                                    <button type="submit" id="searchBtn1" class="btn btn-soft-primary waves-effect waves-light material-shadow-none">Search</button>
                                    {{-- <button type="reset" id="resetBtn1" class="btn btn-soft-secondary waves-effect waves-light material-shadow-none">Reset</button> --}}
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
     <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card-label">
                            <div class="row">
                                <div class="col" style="text-align: left; padding-top: 10px">
                                    @if($batch > 0)

                                    @else
                                    <h4>Total Records Found: <span class="badge bg-success" style="font-size:20px;">{{ $results }}</span></h4>
                                    @endif
                                   
                                    <div>
                                        @if($batch > 0)
                                        <button class="btn btn-soft-danger waves-effect" disabled>IMPORT DATA</button><br><br>
                                        <span class="text-danger">* Please wait, import Pull DB in process.</span>
                                        <script>
                                            setTimeout(function(){
                                                window.location.reload(1);
                                            }, 5000);
                                        </script>
                                        @else 
                                        @if($results > 0)
                                        <button class="btn btn-soft-danger waves-effect" id="btn-import-data-db" >IMPORT DATA</button>
                                        @else
                                        <small>Please select the year, session and exam type to search the data.</small>
                                        @endif
                                        <span class="text-danger" style="display:none;" id="msg-pull"><br><br>* Please wait, import Pull DB in process.</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col">
                                    
                                </div> --}}
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="py-2">
                                
                                <table id="dt-candidates" class="table w-100 table-striped text-center dt-responsive nowrap dataTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th>NO.</th>
                                            <th>YEAR</th>
                                            <th>SESSION NAME</th>
                                            <th>FULL NAME</th>
                                            <th>NRIC </th>
                                            <th>INDEX NO</th>
                                            <th>UPLOAD DATE/TIME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card --> --}}

            </div>
            <!--end col-->
        </div>
    </div>
    

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


            if ($('#dt-candidates').length) {

                var year = $('#year-select').val();
                var session = $('#session-select').val();
                var type = $('#exam-type').val();

            var table = $('#dt-candidates').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('admin.pullDB.ajax') }}",
                    "type": "POST",
                    "data": function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.year = $('#year-select').val();
                        d.session = $('#session-select').val();
                        d.type = $('#exam-type').val();
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            var pageInfo1 = table.page.info();
                            var continuousRowNumber1 = pageInfo1.start + meta.row + 1;
                            return continuousRowNumber1;
                        }
                    },
                    {
                        data: "tahun",
                        orderable: true,
                    },
                    {
                        data: "namasesi",
                        orderable: false,
                    },
                    {
                        data: "nama",
                        orderable: false,
                        //text align left
                        className: "text-left",
                    },
                    {
                        data: "kp",
                        orderable: true,
                        className: "text-left",

                    },
                    {
                        data: "indexNo",
                        orderable: true,
                    },
                    
                    {
                        data: "uploaddt",
                        orderable: true,
                    },
                    
                ],
                pageLength: 10,
                order: [[0, "asc"]],
                responsive: true, // Enable responsive mode
                autoWidth: false,
                buttons: {
                    dom: {
                        button: {
                            tag: 'button',
                            className: 'btn btn-sm'
                        }
                    },
                    buttons: [
                        {
                            extend: "copyHtml5",
                            text: "Salin",
                            className: 'btn-secondary'
                        },
                        // {
                        //     extend: "csvHtml5",
                        //     text: "CSV",
                        //     className: 'btn-secondary'
                        // }
                    ],
                },
                language: {
                    // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                    // "paginate": {
                    // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                    // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                    // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                    // "processing": "Sila tunggu...",
                    // "search": "Carian:"
                },
                searching: true,
                lengthChange: true,
                "initComplete": function(settings, json) {
                    console.log(json, json.data.length);
                    if (json.data.length == 0) {
                        $('#btn-import-data-db').hide();
                    }
                    else{
                        $("#btn-import-data-db").show() 
                    }
                },
                "drawCallback": function(settings) {
                    if (settings.json.data.length == 0) {
                        $('#btn-import-data-db').hide();
                        }
                        else{
                            $("#btn-import-data-db").show()
                        }
                }
                
            });

            
            }

        });

        $(document).ready(function() {
            // Handle the Search button click

            // pullDatabaseAction
            $("#btn-import-data-db").on('click', function(){
                var year = $('#year-select').val();
                var session = $('#session-select').val();
                var type = $('#exam-type').val();
                $("#msg-pull").hide();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to import the data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.pullDB.import') }}",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                year: year,
                                session: session,
                                type: type
                            },
                            success: function(response) {
                                // $('#dt-candidates').DataTable().ajax.reload();
                                $("#btn-import-data-db").prop('disabled', true);
                                $("#msg-pull").show();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.responseJSON.message,
                                    confirmButtonText: 'OK'
                                });
                                $("#btn-import-data-db").prop('disabled', false);
                                $("#msg-pull").hide();
                            }
                        });
                    }
                });
            });

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

                // table redraw with done error callback
                // table.draw(false, null, false, false, false, function() {
                //     Swal.close(); // Close the SweetAlert loading popup
                // });
                // console.log(year, session, type);

                // $('#dt-candidates').DataTable().ajax.reload();

                // console.log('done');

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

    {{-- <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script> --}}
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>

@endsection


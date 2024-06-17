@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            Courier
        @endslot
    @endcomponent

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="row mt-3">
                                <div class="float-start">
                                    {{--                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button> --}}
                                </div>
                                <div class="float-end">
                                    <button class="btn btn-soft-success waves-effect float-end" id="show_create_modal">New
                                        Courier</button>
                                </div>
                            </div>

                            <div class="py-2">

                                <table id="dt-courier" class="table table-striped text-center">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th>NO.</th>
                                            <th>NAME</th>
                                            <th>RATE</th>
                                            <th>JENIS</th>
                                            <th>DURATION</th>
                                            <th>ACTION</th>
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
                <!-- end card -->

            </div>
            <!--end col-->
            @include('modules.admin.administration.courier.modal.create')
            @include('modules.admin.administration.courier.modal.edit')
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if ($("#dt-courier").length > 0) {

                var table = $('#dt-courier').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "./courier/ajax",
                        "type": "POST",
                        "data": function(d) {
                            d._token = $('meta[name="csrf-token"]').attr('content');
                        }
                    },
                    columns: [{
                            data: null,
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                var pageInfo = table.page.info();
                                var continuousRowNumber = pageInfo.start + meta.row + 1;
                                return continuousRowNumber;
                            }
                        },
                        {
                            data: "name",
                            name: 'name',
                            orderable: true,
                        },
                        {
                            data: "rate",
                            name: 'rate',
                            orderable: true,
                        },
                        {
                            data: "currency",
                            name: 'currency'
                        },
                        {
                            data: "duration",
                            name: 'duration'
                        },
                        {
                            data: "action",
                            name: 'action'
                        },
                    ],
                    pageLength: 100,
                    language: {
                        // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                        // "paginate": {
                        // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                        // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                        // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                        "processing": "Processing...",
                        // "search": "Carian:"
                    },
                    searching: false,
                    lengthChange: false,
                });
            }

            $(document).on('click', '#show_edit_modal', function(e) {
                e.preventDefault();
                var id = $(this).val();

                var rowData = table.row($(this).parents('tr')).data();
                $('#form_courier_edit [name="id"]').val(id);
                $('#form_courier_edit [name="name"]').val(rowData.name);
                $('#form_courier_edit [name="currency"]').val(rowData.currency);
                $('#form_courier_edit [name="rate"]').val(rowData.rate);
                $('#form_courier_edit [name="duration"]').val(rowData.duration);

                $('#modal_edit').modal('show');
            })

            $(document).on('click', '#submit_add', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_add')[0]);

                Swal.fire({
                    icon: 'warning',
                    title: 'Adakah Anda Pasti?',
                    text: 'Kurier akan Ditambah!',
                    customClass: {
                        popup: 'my-swal-popup',
                        confirmButton: 'my-swal-confirm',
                        cancelButton: 'my-swal-cancel',
                    },
                    showCancelButton: true, // Show the cancel button
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('courier.store') }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Loading...', // Optional title for the alert
                                    allowEscapeKey: false, // Disables escape key closing the alert
                                    allowOutsideClick: false, // Disables outside click closing the alert
                                    showConfirmButton: false, // Hides the "Confirm" button
                                    didOpen: () => {
                                        Swal.showLoading(Swal
                                        .getDenyButton()); // Show loading indicator on the Deny button
                                    }
                                });
                            },
                            success: function(response) {
                                $('#form_courier_add').removeClass('was-validated');
                                Swal.fire({
                                    type: 'success',
                                    title: 'Berjaya',
                                    text: 'Kurier berjaya ditambah!',
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_create').modal('hide');
                                        $('#dt-courier').DataTable().ajax.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, errors) {
                                $('#form_courier_add').addClass('was-validated');
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Gagal',
                                        text: xhr.responseJSON.message,
                                        customClass: {
                                            popup: 'my-swal-popup',
                                            confirmButton: 'my-swal-confirm',
                                            cancelButton: 'my-swal-cancel',
                                        }
                                    });
                                } 
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#submit', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_edit')[0]);

                const id = $('#id').val();

                Swal.fire({
                    icon: 'warning',
                    title: 'Adakah Anda Pasti?',
                    text: 'Kurier akan Dikemaskini!',
                    customClass: {
                        popup: 'my-swal-popup',
                        confirmButton: 'my-swal-confirm',
                        cancelButton: 'my-swal-cancel',
                    },
                    showCancelButton: true, // Show the cancel button
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('courier.update', '') }}/' + id,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Loading...', // Optional title for the alert
                                    allowEscapeKey: false, // Disables escape key closing the alert
                                    allowOutsideClick: false, // Disables outside click closing the alert
                                    showConfirmButton: false, // Hides the "Confirm" button
                                    didOpen: () => {
                                        Swal.showLoading(Swal
                                        .getDenyButton()); // Show loading indicator on the Deny button
                                    }
                                });
                            },
                            success: function(response) {
                                $('#form_courier_edit').removeClass('was-validated');
                                Swal.fire({
                                    type: 'success',
                                    title: 'Berjaya',
                                    text: 'Kurier berjaya dikemaskini!',
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_edit').modal('hide');
                                        $('#dt-courier').DataTable().ajax.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, errors) {
                                $('#form_courier_edit').addClass('was-validated');
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Gagal',
                                        text: xhr.responseJSON.message,
                                        customClass: {
                                            popup: 'my-swal-popup',
                                            confirmButton: 'my-swal-confirm',
                                            cancelButton: 'my-swal-cancel',
                                        }
                                    });
                                } 
                            }
                        });
                    }
                });
            });
            
            $(document).on('click', '#delete', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_edit')[0]);

                const id = $('#id').val();

                Swal.fire({
                    icon: 'warning',
                    title: 'Adakah Anda Pasti?',
                    text: 'Kurier akan Dipadam!',
                    customClass: {
                        popup: 'my-swal-popup',
                        confirmButton: 'my-swal-confirm',
                        cancelButton: 'my-swal-cancel',
                    },
                    showCancelButton: true, // Show the cancel button
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('courier.destroy', '') }}/' + id,
                            method: 'DELETE',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Loading...', // Optional title for the alert
                                    allowEscapeKey: false, // Disables escape key closing the alert
                                    allowOutsideClick: false, // Disables outside click closing the alert
                                    showConfirmButton: false, // Hides the "Confirm" button
                                    didOpen: () => {
                                        Swal.showLoading(Swal
                                        .getDenyButton()); // Show loading indicator on the Deny button
                                    }
                                });
                            },
                            success: function(response) {
                                $('#form_courier_edit').removeClass('was-validated');
                                Swal.fire({
                                    type: 'success',
                                    title: 'Berjaya',
                                    text: 'Kurier berjaya dipadam!',
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_edit').modal('hide');
                                        $('#dt-courier').DataTable().ajax.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, errors) {
                                $('#form_courier_edit').addClass('was-validated');
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Gagal',
                                        text: xhr.responseJSON.message,
                                        customClass: {
                                            popup: 'my-swal-popup',
                                            confirmButton: 'my-swal-confirm',
                                            cancelButton: 'my-swal-cancel',
                                        }
                                    });
                                } 
                            }
                        });
                    }
                });
            });

            $('#show_create_modal').on('click', function() {
                $('#modal_create').modal('show');
            });
        });
    </script>
@endsection

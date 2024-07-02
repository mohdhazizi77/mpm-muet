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
            General Setting
        @endslot
    @endcomponent

    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4  border-top card-custom mb-2">
                <div class="card-body">
                    <h5 class="card-title">Rate</h5>
                    <form action="{{ route('general_setting.store') }}" method="POST">
                        @csrf <!-- Include CSRF token for security -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="mpmRate" class="form-label">Printing by MPM</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                    <input type="number" step="any" class="form-control" id="mpmRate" name="rate_mpmprint" value="{{ isset($config['rate_mpmprint']) ? $config['rate_mpmprint'] : '' }}" placeholder="Enter rate">
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="selfPrintRate" class="form-label">Self print PDF</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                    <input type="number" step="any" class="form-control" id="selfPrintRate" name="rate_selfprint" value="{{ isset($config['rate_selfprint']) ? $config['rate_selfprint'] : '' }}" placeholder="Enter rate">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="mpmRate" class="form-label">Email Alert</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                    <input type="number" step="any" class="form-control" id="email_alert_order" name="email_alert_order" value="{{ isset($config['email_alert_order']) ? $config['email_alert_order'] : '' }}" placeholder="Enter rate">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </form>
                </div>
            </div>
            {{-- <div class="card rounded-0 bg-white mx-n4  border-top card-custom mb-2">
                <div class="card-body">
                    <h5 class="card-title">Integration : MPM Bayar</h5>
                    <form>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="mpmRate" class="form-label">URL</label>
                                <input type="number" step="any" class="form-control" id="mpmRate" placeholder="Enter URL (https://mpmbayar.com)">
                            </div>
                            <div class="col-4">
                                <label for="selfPrintRate" class="form-label">Token</label>
                                <input type="number" step="any" class="form-control" id="selfPrintRate" placeholder="Enter token">
                            </div>
                            <div class="col-4">
                                <label for="selfPrintRate" class="form-label">Secret Key</label>
                                <input type="number" step="any" class="form-control" id="selfPrintRate" placeholder="Enter secret key">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div> --}}
            <div class="card rounded-0 bg-white mx-n4  border-top card-custom mt-1">
                <div class="card-header">
                    <div class="row">
                        <div class="col" style="text-align: left">
                            List Courier
                        </div>
                        <div class="col" style="text-align: right">
                            <button class="btn btn-soft-success waves-effect float-end" id="show_create_modal">New Courier</button>
                        </div>
                    </div>
                </div>
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">

                            <div class="py-2">

                                <table id="dt-courier" class="table w-100 table-striped text-center dt-responsive nowrap dataTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th>NO.</th>
                                            <th>NAME</th>
                                            <th>RATE</th>
                                            <th>CURRENCY</th>
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
                    dom: 'frtp',
                    pageLength: 10,
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
                $('#form_courier_edit').removeClass('was-validated');
                $('#form_courier_edit')[0].reset();

                var rowData = table.row($(this).parents('tr')).data();
                $('#form_courier_edit [name="id"]').val(id);
                $('#form_courier_edit [name="name"]').val(rowData.name);
                $('#form_courier_edit [name="currency"]').val(rowData.currency);
                $('#form_courier_edit [name="rate"]').val(rowData.rate);
                $('#form_courier_edit [name="duration"]').val(rowData.duration);

                $('#modal_edit').modal('show');
            })

            $(document).on('click', '#submit_store', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_add')[0]);

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Courier will be added!',
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
                                    title: 'Succeeded',
                                    text: 'Courier successfully added!',
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
                                    $.each(xhr.responseJSON.errors, function(key,
                                    value) {
                                        if (key == "is_active") {
                                            $('#form_courier_add [name="' +
                                                key +
                                                '"]').closest(
                                                '.form-check').find(
                                                '.invalid-feedback').html(
                                                value[
                                                    0]);
                                        } else {
                                            $('#form_courier_add [name="' +
                                                    key +
                                                    '"]').removeAttr(
                                                    'readonly').next(
                                                    '.invalid-feedback').show()
                                                .html(
                                                    value[0]);
                                        }
                                    });
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

            $(document).on('click', '#submit_edit', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_edit')[0]);

                const id = $('#id').val();

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Courier will be updated!',
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
                                    title: 'Succeeded',
                                    text: 'Courier successfully updated!',
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
                                    $.each(xhr.responseJSON.errors, function(key,
                                    value) {
                                        if (key == "is_active") {
                                            $('#form_courier_edit [name="' +
                                                key +
                                                '"]').closest(
                                                '.form-check').find(
                                                '.invalid-feedback').html(
                                                value[
                                                    0]);
                                        } else {
                                            $('#form_courier_edit [name="' +
                                                    key +
                                                    '"]').removeAttr(
                                                    'readonly').next(
                                                    '.invalid-feedback').show()
                                                .html(
                                                    value[0]);
                                        }
                                    });
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
                e.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_courier_edit')[0]);

                var id = $(this).val();

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
                $('#form_courier_add').removeClass('was-validated');
                $('#form_courier_add')[0].reset();
                $('#modal_create').modal('show');
            });
        });
    </script>
@endsection

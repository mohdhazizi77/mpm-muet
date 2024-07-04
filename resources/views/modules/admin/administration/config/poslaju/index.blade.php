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
            Pos Laju Integration
        @endslot
    @endcomponent

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row py-1 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4  border-top card-custom mb-2">
                <div class="card-body">

        @if($configPoslaju)
            <form action="{{ route('config_poslaju.update') }}" method="POST">
                @csrf
                @method('POST')

                <h5>Token</h5>
                <div class="form-group col-6">
                    <label for="url">URL</label>
                    <i class="ri-information-fill" data-toggle="tooltip" data-placement="top" title=""></i>
                    <input type="text" class="form-control" id="url" name="url" value="{{ $configPoslaju->url }}" required>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="client_id">Client ID</label>
                        <input type="text" class="form-control" id="client_id" name="client_id" value="{{ $configPoslaju->client_id }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="client_secret">Client Secret</label>
                        <input type="text" class="form-control" id="client_secret" name="client_secret" value="{{ $configPoslaju->client_secret }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="grant_type">Grant Type</label>
                        <input type="text" class="form-control" id="grant_type" name="grant_type" value="{{ $configPoslaju->grant_type }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="scope">Scope</label>
                        <input type="text" class="form-control" id="scope" name="scope" value="{{ $configPoslaju->scope }}" required>
                    </div>
                </div>

                <hr>
                <h5>Consignment Notes</h5>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="Prefix">Prefix</label>
                        <input type="text" class="form-control" id="Prefix" name="Prefix" value="{{ $configPoslaju->Prefix }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="ApplicationCode">Application Code</label>
                        <input type="text" class="form-control" id="ApplicationCode" name="ApplicationCode" value="{{ $configPoslaju->ApplicationCode }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="Secretid">Secret ID</label>
                        <input type="text" class="form-control" id="Secretid" name="Secretid" value="{{ $configPoslaju->Secretid }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $configPoslaju->username }}" required>
                    </div>
                </div>

                <hr>
                <h5>PreAcceptance Single</h5>

                {{-- <div class="form-group">
                    <label for="requireToPickup">Require To Pickup</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="requireToPickupYes" name="requireToPickup" value="1" {{ $configPoslaju->requireToPickup ? 'checked' : '' }}>
                        <label class="form-check-label" for="requireToPickupYes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="requireToPickupNo" name="requireToPickup" value="0" {{ !$configPoslaju->requireToPickup ? 'checked' : '' }}>
                        <label class="form-check-label" for="requireToPickupNo">No</label>
                    </div>
                </div> --}}

                {{-- <div class="form-group">
                    <label for="requireWebHook">Require Web Hook</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="requireWebHookYes" name="requireWebHook" value="1" {{ $configPoslaju->requireWebHook ? 'checked' : '' }}>
                        <label class="form-check-label" for="requireWebHookYes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="requireWebHookNo" name="requireWebHook" value="0" {{ !$configPoslaju->requireWebHook ? 'checked' : '' }}>
                        <label class="form-check-label" for="requireWebHookNo">No</label>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="form-group col-6">
                        <label for="subscriptionCode">Subscription Code</label>
                        <input type="text" class="form-control" id="subscriptionCode" name="subscriptionCode" value="{{ $configPoslaju->subscriptionCode }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="accountNo">Account No</label>
                        <input type="number" class="form-control" id="accountNo" name="accountNo" value="{{ $configPoslaju->accountNo }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="callerName">Person In Charge Name</label>
                        <input type="text" class="form-control" id="callerName" name="callerName" value="{{ $configPoslaju->callerName }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="callerPhone">Person In Charge Phone</label>
                        <input type="text" class="form-control" id="callerPhone" name="callerPhone" value="{{ $configPoslaju->callerPhone }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-4">
                        <label for="contactPerson">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson" name="contactPerson" value="{{ $configPoslaju->contactPerson }}" required>
                    </div>

                    <div class="form-group col-4">
                        <label for="phoneNo">Phone No</label>
                        <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="{{ $configPoslaju->phoneNo }}" required>
                    </div>

                    <div class="form-group col-4">
                        <label for="pickupEmail">Pickup Email</label>
                        <input type="email" class="form-control" id="pickupEmail" name="pickupEmail" value="{{ $configPoslaju->pickupEmail }}" required>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="pickupLocationID">Pickup Location ID</label>
                        <input type="text" class="form-control" id="pickupLocationID" name="pickupLocationID" value="{{ $configPoslaju->pickupLocationID }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="pickupLocationName">Pickup Location Name</label>
                        <input type="text" class="form-control" id="pickupLocationName" name="pickupLocationName" value="{{ $configPoslaju->pickupLocationName }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="pickupAddress">Pickup Address</label>
                        <input type="text" class="form-control" id="pickupAddress" name="pickupAddress" value="{{ $configPoslaju->pickupAddress }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="pickupDistrict">Pickup District</label>
                        <input type="text" class="form-control" id="pickupDistrict" name="pickupDistrict" value="{{ $configPoslaju->pickupDistrict }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group col-4">
                        <label for="pickupProvince">Pickup Province</label>
                        <input type="text" class="form-control" id="pickupProvince" name="pickupProvince" value="{{ $configPoslaju->pickupProvince }}" required>
                    </div>

                    <div class="form-group col-4">
                        <label for="postCode">Post Code</label>
                        <input type="number" class="form-control" id="postCode" name="postCode" value="{{ $configPoslaju->postCode }}" required>
                    </div>

                    <div class="form-group col-4">
                        <label for="pickupCountry">Pickup Country</label>
                        <input type="text" class="form-control" id="pickupCountry" name="pickupCountry" value="{{ $configPoslaju->pickupCountry }}" required>
                    </div>
                </div>

                {{-- <div class="form-group">
                    <label for="ItemType">Item Type</label>
                    <input type="number" class="form-control" id="ItemType" name="ItemType" value="{{ $configPoslaju->ItemType }}">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="totalQuantityToPickup">Total Quantity To Pickup</label>
                    <input type="number" class="form-control" id="totalQuantityToPickup" name="totalQuantityToPickup" value="{{ $configPoslaju->totalQuantityToPickup }}">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="PaymentType">Payment Type</label>
                    <input type="text" class="form-control" id="PaymentType" name="PaymentType" value="{{ $configPoslaju->PaymentType }}">
                </div> --}}

                <div class="row mt-2">
                    <div class="form-group col-6">
                        <label for="readyToCollectAt">Ready To Collect At</label>
                        <input type="text" class="form-control" id="readyToCollectAt" name="readyToCollectAt" value="{{ $configPoslaju->readyToCollectAt }}" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="closeAt">Close At</label>
                        <input type="text" class="form-control" id="closeAt" name="closeAt" value="{{ $configPoslaju->closeAt }}" required>
                    </div>
                </div>

                {{-- <div class="form-group">
                    <label for="ShipmentName">Shipment Name</label>
                    <input type="text" class="form-control" id="ShipmentName" name="ShipmentName" value="{{ $configPoslaju->ShipmentName }}">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="currency">Currency</label>
                    <input type="text" class="form-control" id="currency" name="currency" value="{{ $configPoslaju->currency }}">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="countryCode">Country Code</label>
                    <input type="text" class="form-control" id="countryCode" name="countryCode" value="{{ $configPoslaju->countryCode }}">
                </div> --}}


                <button type="submit" class="btn btn-primary mt-4 float-end">Save</button>
            </form>
        @else
            <p>No Config Poslaju record found.</p>
        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
    </div>
@endsection
@section('script')
    <script>
        // $(document).ready(function() {
        //     if ($("#dt-courier").length > 0) {

        //         var table = $('#dt-courier').DataTable({
        //             processing: true,
        //             serverSide: true,
        //             ajax: {
        //                 "url": "./courier/ajax",
        //                 "type": "POST",
        //                 "data": function(d) {
        //                     d._token = $('meta[name="csrf-token"]').attr('content');
        //                 }
        //             },
        //             columns: [{
        //                     data: null,
        //                     searchable: false,
        //                     orderable: false,
        //                     render: function(data, type, row, meta) {
        //                         var pageInfo = table.page.info();
        //                         var continuousRowNumber = pageInfo.start + meta.row + 1;
        //                         return continuousRowNumber;
        //                     }
        //                 },
        //                 {
        //                     data: "name",
        //                     name: 'name',
        //                     orderable: true,
        //                 },
        //                 {
        //                     data: "rate",
        //                     name: 'rate',
        //                     orderable: true,
        //                 },
        //                 {
        //                     data: "currency",
        //                     name: 'currency'
        //                 },
        //                 {
        //                     data: "duration",
        //                     name: 'duration'
        //                 },
        //                 {
        //                     data: "action",
        //                     name: 'action'
        //                 },
        //             ],
        //             dom: 'frtp',
        //             pageLength: 10,
        //             language: {
        //                 // "zeroRecords": "Tiada rekod untuk dipaparkan.",
        //                 // "paginate": {
        //                 // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
        //                 // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
        //                 // "infoFiltered": "(tapisan dari _MAX_ rekod)",
        //                 "processing": "Processing...",
        //                 // "search": "Carian:"
        //             },
        //             searching: false,
        //             lengthChange: false,
        //         });
        //     }

        //     $(document).on('click', '#show_edit_modal', function(e) {
        //         e.preventDefault();
        //         var id = $(this).val();
        //         $('#form_courier_edit').removeClass('was-validated');
        //         $('#form_courier_edit')[0].reset();

        //         var rowData = table.row($(this).parents('tr')).data();
        //         $('#form_courier_edit [name="id"]').val(id);
        //         $('#form_courier_edit [name="name"]').val(rowData.name);
        //         $('#form_courier_edit [name="currency"]').val(rowData.currency);
        //         $('#form_courier_edit [name="rate"]').val(rowData.rate);
        //         $('#form_courier_edit [name="duration"]').val(rowData.duration);

        //         $('#modal_edit').modal('show');
        //     })

        //     $(document).on('click', '#submit_store', function(e) {
        //         var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //         var formData = new FormData($('#form_courier_add')[0]);

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Are you sure?',
        //             text: 'Courier will be added!',
        //             customClass: {
        //                 popup: 'my-swal-popup',
        //                 confirmButton: 'my-swal-confirm',
        //                 cancelButton: 'my-swal-cancel',
        //             },
        //             showCancelButton: true, // Show the cancel button
        //             confirmButtonText: 'Ya',
        //             cancelButtonText: 'Tidak'
        //         }).then((result) => {
        //             if (result.value) {
        //                 $.ajax({
        //                     url: '{{ route('courier.store') }}',
        //                     method: 'POST',
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     headers: {
        //                         'X-CSRF-TOKEN': csrfToken
        //                     },
        //                     beforeSend: function() {
        //                         Swal.fire({
        //                             title: 'Loading...', // Optional title for the alert
        //                             allowEscapeKey: false, // Disables escape key closing the alert
        //                             allowOutsideClick: false, // Disables outside click closing the alert
        //                             showConfirmButton: false, // Hides the "Confirm" button
        //                             didOpen: () => {
        //                                 Swal.showLoading(Swal
        //                                 .getDenyButton()); // Show loading indicator on the Deny button
        //                             }
        //                         });
        //                     },
        //                     success: function(response) {
        //                         $('#form_courier_add').removeClass('was-validated');
        //                         Swal.fire({
        //                             type: 'success',
        //                             title: 'Succeeded',
        //                             text: 'Courier successfully added!',
        //                             customClass: {
        //                                 popup: 'my-swal-popup',
        //                                 confirmButton: 'my-swal-confirm',
        //                                 cancelButton: 'my-swal-cancel',
        //                             }
        //                         }).then((result) => {
        //                             if (result.value) {
        //                                 $('#modal_create').modal('hide');
        //                                 $('#dt-courier').DataTable().ajax.reload();
        //                             }
        //                         });
        //                     },
        //                     error: function(xhr, status, errors) {
        //                         $('#form_courier_add').addClass('was-validated');
        //                         if (xhr.responseJSON && xhr.responseJSON.errors) {
        //                             $.each(xhr.responseJSON.errors, function(key,
        //                             value) {
        //                                 if (key == "is_active") {
        //                                     $('#form_courier_add [name="' +
        //                                         key +
        //                                         '"]').closest(
        //                                         '.form-check').find(
        //                                         '.invalid-feedback').html(
        //                                         value[
        //                                             0]);
        //                                 } else {
        //                                     $('#form_courier_add [name="' +
        //                                             key +
        //                                             '"]').removeAttr(
        //                                             'readonly').next(
        //                                             '.invalid-feedback').show()
        //                                         .html(
        //                                             value[0]);
        //                                 }
        //                             });
        //                             Swal.fire({
        //                                 icon: "error",
        //                                 title: 'Gagal',
        //                                 text: xhr.responseJSON.message,
        //                                 customClass: {
        //                                     popup: 'my-swal-popup',
        //                                     confirmButton: 'my-swal-confirm',
        //                                     cancelButton: 'my-swal-cancel',
        //                                 }
        //                             });
        //                         }
        //                     }
        //                 });
        //             }
        //         });
        //     });

        //     $(document).on('click', '#submit_edit', function(e) {
        //         var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //         var formData = new FormData($('#form_courier_edit')[0]);

        //         const id = $('#id').val();

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Are you sure?',
        //             text: 'Courier will be updated!',
        //             customClass: {
        //                 popup: 'my-swal-popup',
        //                 confirmButton: 'my-swal-confirm',
        //                 cancelButton: 'my-swal-cancel',
        //             },
        //             showCancelButton: true, // Show the cancel button
        //             confirmButtonText: 'Ya',
        //             cancelButtonText: 'Tidak'
        //         }).then((result) => {
        //             if (result.value) {
        //                 $.ajax({
        //                     url: '{{ route('courier.update', '') }}/' + id,
        //                     method: 'POST',
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     headers: {
        //                         'X-CSRF-TOKEN': csrfToken
        //                     },
        //                     beforeSend: function() {
        //                         Swal.fire({
        //                             title: 'Loading...', // Optional title for the alert
        //                             allowEscapeKey: false, // Disables escape key closing the alert
        //                             allowOutsideClick: false, // Disables outside click closing the alert
        //                             showConfirmButton: false, // Hides the "Confirm" button
        //                             didOpen: () => {
        //                                 Swal.showLoading(Swal
        //                                 .getDenyButton()); // Show loading indicator on the Deny button
        //                             }
        //                         });
        //                     },
        //                     success: function(response) {
        //                         $('#form_courier_edit').removeClass('was-validated');
        //                         Swal.fire({
        //                             type: 'success',
        //                             title: 'Succeeded',
        //                             text: 'Courier successfully updated!',
        //                             customClass: {
        //                                 popup: 'my-swal-popup',
        //                                 confirmButton: 'my-swal-confirm',
        //                                 cancelButton: 'my-swal-cancel',
        //                             }
        //                         }).then((result) => {
        //                             if (result.value) {
        //                                 $('#modal_edit').modal('hide');
        //                                 $('#dt-courier').DataTable().ajax.reload();
        //                             }
        //                         });
        //                     },
        //                     error: function(xhr, status, errors) {
        //                         $('#form_courier_edit').addClass('was-validated');
        //                         if (xhr.responseJSON && xhr.responseJSON.errors) {
        //                             $.each(xhr.responseJSON.errors, function(key,
        //                             value) {
        //                                 if (key == "is_active") {
        //                                     $('#form_courier_edit [name="' +
        //                                         key +
        //                                         '"]').closest(
        //                                         '.form-check').find(
        //                                         '.invalid-feedback').html(
        //                                         value[
        //                                             0]);
        //                                 } else {
        //                                     $('#form_courier_edit [name="' +
        //                                             key +
        //                                             '"]').removeAttr(
        //                                             'readonly').next(
        //                                             '.invalid-feedback').show()
        //                                         .html(
        //                                             value[0]);
        //                                 }
        //                             });
        //                             Swal.fire({
        //                                 icon: "error",
        //                                 title: 'Gagal',
        //                                 text: xhr.responseJSON.message,
        //                                 customClass: {
        //                                     popup: 'my-swal-popup',
        //                                     confirmButton: 'my-swal-confirm',
        //                                     cancelButton: 'my-swal-cancel',
        //                                 }
        //                             });
        //                         }
        //                     }
        //                 });
        //             }
        //         });
        //     });

        //     $(document).on('click', '#delete', function(e) {
        //         e.preventDefault();
        //         var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //         var formData = new FormData($('#form_courier_edit')[0]);

        //         var id = $(this).val();

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Adakah Anda Pasti?',
        //             text: 'Kurier akan Dipadam!',
        //             customClass: {
        //                 popup: 'my-swal-popup',
        //                 confirmButton: 'my-swal-confirm',
        //                 cancelButton: 'my-swal-cancel',
        //             },
        //             showCancelButton: true, // Show the cancel button
        //             confirmButtonText: 'Ya',
        //             cancelButtonText: 'Tidak'
        //         }).then((result) => {
        //             if (result.value) {
        //                 $.ajax({
        //                     url: '{{ route('courier.destroy', '') }}/' + id,
        //                     method: 'DELETE',
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     headers: {
        //                         'X-CSRF-TOKEN': csrfToken
        //                     },
        //                     beforeSend: function() {
        //                         Swal.fire({
        //                             title: 'Loading...', // Optional title for the alert
        //                             allowEscapeKey: false, // Disables escape key closing the alert
        //                             allowOutsideClick: false, // Disables outside click closing the alert
        //                             showConfirmButton: false, // Hides the "Confirm" button
        //                             didOpen: () => {
        //                                 Swal.showLoading(Swal
        //                                 .getDenyButton()); // Show loading indicator on the Deny button
        //                             }
        //                         });
        //                     },
        //                     success: function(response) {
        //                         $('#form_courier_edit').removeClass('was-validated');
        //                         Swal.fire({
        //                             type: 'success',
        //                             title: 'Berjaya',
        //                             text: 'Kurier berjaya dipadam!',
        //                             customClass: {
        //                                 popup: 'my-swal-popup',
        //                                 confirmButton: 'my-swal-confirm',
        //                                 cancelButton: 'my-swal-cancel',
        //                             }
        //                         }).then((result) => {
        //                             if (result.value) {
        //                                 $('#modal_edit').modal('hide');
        //                                 $('#dt-courier').DataTable().ajax.reload();
        //                             }
        //                         });
        //                     },
        //                     error: function(xhr, status, errors) {
        //                         $('#form_courier_edit').addClass('was-validated');
        //                         if (xhr.responseJSON && xhr.responseJSON.errors) {
        //                             Swal.fire({
        //                                 icon: "error",
        //                                 title: 'Gagal',
        //                                 text: xhr.responseJSON.message,
        //                                 customClass: {
        //                                     popup: 'my-swal-popup',
        //                                     confirmButton: 'my-swal-confirm',
        //                                     cancelButton: 'my-swal-cancel',
        //                                 }
        //                             });
        //                         }
        //                     }
        //                 });
        //             }
        //         });
        //     });

        //     $('#show_create_modal').on('click', function() {
        //         $('#form_courier_add').removeClass('was-validated');
        //         $('#form_courier_add')[0].reset();
        //         $('#modal_create').modal('show');
        //     });
        // });
    </script>
@endsection

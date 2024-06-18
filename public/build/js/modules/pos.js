$(document).ready(function() {

    if ($('#posNewTable').length) {

        var table = $('#posNewTable').DataTable({
            // dom: '<"top"rt><"bottom"lp><"clear">', // Hides the built-in search bar
            processing: true,
            serverSide: true,

            ajax: {
                "url": "/pos/new/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posNewTable').data('type');
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.textSearch = $('#text-search').val();
                }
            },
            columns: [
                // Checkbox column
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="form-check-input row-checkbox" data-id="' + data.id + '">';
                    }
                },
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },
                {
                    data: "order_date",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                {
                    data: "details",
                    orderable: false,
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                }
            ],
            // pageLength: 50,
            // order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
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
            lengthChange: false,
        });
    }

    $(document).on('click', '.btn-cancel-pos', function() {

        Swal.fire({
            title: "Are you sure?",
            text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/new/cancel',
                    type: 'POST',
                    data: $('form').serialize(),
                    success: function(response){
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function(xhr, status, error){
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    $(document).on('click', '.btn-approve-new', function() {

        Swal.fire({
            title: "Are you sure?",
            text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/new/update',
                    type: 'POST',
                    data: $('form').serialize(),
                    success: function(response){
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function(xhr, status, error){
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    $(document).on('click', '.btn-update-pos', function() {

        var recordId = $(this).data('id');
        $.ajax({
            url: './new/getPosDetail', // Replace with your endpoint
            method: 'GET',
            data: { id: recordId },
            beforeSend:function(){
                Swal.fire({
                    title: 'Loading...', // Optional title for the alert
                    allowEscapeKey: false,  // Disables escape key closing the alert
                    allowOutsideClick: false, // Disables outside click closing the alert
                    showConfirmButton: false, // Hides the "Confirm" button
                    didOpen: () => {
                        Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                    }
                });
            },
            success: function(response) {
                Swal.close()
                console.log(response);
                // Populate modal with record details
                $('#name').val(response.candidate.nama)
                $('#nric').val(response.candidate.kp)
                // $('#phone_num').val(response.candidate.phone_num)
                // $('#email').val(response.candidate.email)
                $('#address').val(response.candidate.alamat1)
                $('#postcode').val(response.candidate.poskod)
                $('#city').val(response.candidate.bandar)
                $('#state').val(response.candidate.negeri_id)
                // $('#name').val(response.name);
                // $('#email').val(response.email);
                $('#order_id').val(response.order.order_id)

                if ($(".shipping_info").length) {
                    $('#ship_name').val(response.order.name)
                    $('#ship_phoneNum').val(response.order.phone_num)
                    $('#ship_email').val(response.order.email)
                    $('#ship_address').val(response.order.address1)
                    $('#ship_postcode').val(response.order.postcode)
                    $('#ship_city').val(response.order.city)
                    $('#ship_state').val(response.order.state)
                    $('#ship_trackNum').val(response.order.tracking_number)
                    $('#ship_trackRemarks').val(response.order.type)

                    $('#button-print-certificate-pdf').attr('href', '/pos/candidates-downloadpdf/' + response.candidate.candidate_cryptId);

                }


                // Show the modal
                $('#modalUpdatePos').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });

    if ($('#posProcessTable').length) {

        var table = $('#posProcessTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/processing/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posProcessTable').data('type');
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.noTracking = $('#noTracking').val();
                    d.textSearch = $('#text-search').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="form-check-input row-checkbox" data-id="' + data.id + '">';
                    }
                },
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },
                {
                    data: "order_date",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                {
                    data: "details",
                    orderable: false,
                    render(data, type, row) {
                        let html = '';
                        html = data + '<br><p>Tracking Number : '+row.tracking_number+'</p>';

                        return html;
                    }
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';

                        return btn;
                    }
                },
                {
                    data: "tracking_number",
                    orderable: false,
                    visible: false,
                },
            ],
            // pageLength: 50,
            // order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
            language: {
                // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                // "paginate": {
                // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                // "processing": "Sila tunggu...",
                // "search": "Carian:"
            },
            searching: false,
            lengthChange: false,
        });
    }

    $('#noTracking').on('change', function() {
        if (this.checked) {
            $(this).prop('value', '1');
            $('#noTrackingLabel').text('Checked');
        } else {
            $(this).prop('value', '0');
            $('#noTrackingLabel').text('Unchecked');
        }
    });

    $(document).on('click', '.btn-approve-processing', function() {

        Swal.fire({
            title: "Are you sure?",
            text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/processing/update',
                    type: 'POST',
                    data: $('form').serialize(),
                    success: function(response){
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            table.ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            table.draw(); // This line redraws the DataTable
                        } else {
                            console.log(response);
                            // Swal.fire("Error!", "Failed to update data.", "error");
                            Swal.fire("Error!", response.message, "error");

                        }
                    },
                    error: function(xhr, status, error){
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    if ($('#posCompleteTable').length) {
        var table = $('#posCompleteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/complete/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posCompleteTable').data('type');
                    d.textSearch = $('#text-search').val();
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "order_date",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                {
                    data: "details",
                    orderable: false,
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                }

            ],
            // pageLength: 50,
            // order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
            language: {
                // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                // "paginate": {
                // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                // "processing": "Sila tunggu...",
                // "search": "Carian:"
            },
            searching: false,
            lengthChange: false,
        });
    }

    var today = new Date().toISOString().split('T')[0];
    $('#start-date').attr('max', today);

    // Enable/disable the end date input based on the start date value
    $('#start-date').on('change', function() {
        if ($(this).val()) {
            $('#end-date').prop('disabled', false);
        } else {
            $('#end-date').prop('disabled', true);
        }

        var startDate = $(this).val();
        $('#end-date').attr('min', startDate).prop('disabled', !startDate);
        $('#end-date').val(startDate)
    });

    $('#text-search').on('keyup change', function() {
        table.search(this.value).draw();
    });

    $(document).on('click', '#filterBtn', function (){

        table.ajax.reload();

        // // Redraw the DataTable
        // // $('#posNewTable').DataTable().ajax.reload();
        // var startDate = $('#start-date').val();
        // var endDate = $('#end-date').val();
        // var textSearch = $('#text-search').val();

        // function parseDate(dateString) {
        //     var parts = dateString.split('/');
        //     // Note: months are 0-based in JavaScript's Date object
        //     return new Date(parts[2], parts[1] - 1, parts[0]);
        // }

        // console.log(startDate, endDate, textSearch);

        // // // Convert dates to the desired format
        // startDate = startDate ? new Date(startDate).toISOString().split('T')[0] : '';
        // endDate = endDate ? new Date(endDate).toISOString().split('T')[0] : new Date().toISOString().split('T')[0];
        // // console.log(startDate, endDate);

        // // table.rows().every(function() {
        // //     var data = this.data();
        // //     // console.log(data.order_date)

        // //     var orderDate = parseDate(data.order_date).toISOString().split('T')[0];

        // //     var matchesDateRange = (!startDate || orderDate >= startDate) && (!endDate || orderDate <= endDate);
        // //     var matchesTextSearch = !textSearch ||
        // //         data.details.toLowerCase().includes(textSearch.toLowerCase()) ||
        // //         data.order_id.toLowerCase().includes(textSearch.toLowerCase());
        // //     // console.log(orderDate)
        // //     // console.log(data.details, data.order_id)
        // //     console.log(matchesDateRange,matchesTextSearch)
        // //     if (matchesDateRange && matchesTextSearch) {
        // //         this.node().style.display = '';
        // //     } else {
        // //         this.node().style.display = 'none';
        // //     }
        // // });

        // // table.draw();


        // // Custom search logic
        // $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        //     // var orderDate = parseDate(data.order_date).toISOString().split('T')[0]; // Assuming date is in the first column
        //     var orderDate = data[0].split('/').reverse().join('-');
        //     var matchesDateRange = (!startDate || orderDate >= startDate) && (!endDate || orderDate <= endDate);
        //     var matchesTextSearch = !textSearch ||
        //         data.details.toLowerCase().includes(textSearch.toLowerCase()) || // Assuming details is in the third column
        //         data.order_id.toLowerCase().includes(textSearch.toLowerCase()); // Assuming order_id is in the second column

        //     return matchesDateRange && matchesTextSearch;
        // });

        // table.draw(); // Redraw the table
        // $.fn.dataTable.ext.search.pop(); // Remove the custom search function
    })

    //clear filter
    $(document).on('click', '#resetBtn', function (){
        $('#start-date').val('');
        $('#end-date').val('');
        $('#text-search').val('');

        $('#noTracking').prop('value', '0');
        $('#noTracking').prop('checked', false);

        table.ajax.reload();
    })


    // BULK ACTION
    $(document).on('click', '.check-all', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    $(document).on('click', '#btnBulkCancel', function() {
        var orderIds = [];
        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if(orderIds.length > 0){
            Swal.fire({
                title: "Are you sure to bulk cancel?",
                text: "Once cancel, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/new/bulk/cancel',
                        type: 'POST',
                        data: postData,
                        beforeSend:function(){
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function(response){
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
              })
        }

    });

    $(document).on('click', '#btnBulkApprove', function() {
        var orderIds = [];

        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if(orderIds.length > 0){
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/new/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend:function(){
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function(response){
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
              })
        }

    });

    $(document).on('click', '#btnBulkComplete', function() {
        var orderIds = [];

        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });
        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if(orderIds.length > 0){
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Please make sure all the record already have tracking number. Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/processing/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend:function(){
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function(response){
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
              })
        }

    });

    $(document).on('click', '#btnExportExcel', function (){

        var type = $(this).data('type');
        window.location.href = '/admin/pos-management/'+type+'/generateExcel';
    });
    
    $(document).on('click', '#button-export-xlsx', function (){

        var type = $(this).data('type');
        window.location.href = '/admin/pos-management/'+type+'/generateExcel';
    });
    
    $(document).on('click', '#button-export-pos-xlsx', function (){

        var type = $(this).data('type');
        window.location.href = '/admin/pos-management/'+type+'/generateExcelPos';
    });
    
    $(document).on('click', '#button-import-pos-xlsx', function (){
        $('#formFile').val('');
        $('#modal_upload_xlsx').modal('show');
    });

    $(document).on('click', '#submit-upload', function(e) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData($('#form_upluad_xlsx')[0]);

        Swal.fire({
            type: 'warning',
            title: 'Adakah Anda Pasti?',
            text: 'Fail Xlsx Akan di Muat Naik!',
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
                var type = 'PROCESSING'; 
                var url = '/admin/pos-management/' + type + '/generateImportExcelPos';
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    beforeSend:function(){
                        Swal.fire({
                            title: 'Loading...', // Optional title for the alert
                            allowEscapeKey: false,  // Disables escape key closing the alert
                            allowOutsideClick: false, // Disables outside click closing the alert
                            showConfirmButton: false, // Hides the "Confirm" button
                            didOpen: () => {
                                Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                            }
                        });
                    },
                    success: function(response) {
                        $('#form_upluad_xlsx').removeClass('was-validated');
                        Swal.fire({
                            type: 'success',
                            title: 'Berjaya',
                            text: 'Berjaya Muat Naik Xlsx',
                            customClass: {
                                popup: 'my-swal-popup',
                                confirmButton: 'my-swal-confirm',
                                cancelButton: 'my-swal-cancel',
                            }
                        }).then((result) => {
                            if (result.value) {
                                $('#modal_upload_xlsx').modal('hide');
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, errors) {
                        $('#form_upluad_xlsx').addClass('was-validated');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            console.log(xhr.responseJSON.errors);
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

                            var firstError = Object.values(xhr.responseJSON.errors)[0][0];
                            $('#show-validate').text(firstError);
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: 'Gagal',
                                text: xhr.responseText,
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            });
                            $('#show-validate').text(xhr.responseText);
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnBulkProcessing', function() {
        var orderIds = [];

        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if(orderIds.length > 0){
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/processing/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend:function(){
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function(response){
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posProcessTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posProcessTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error){
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
              })
        }

    });
    
    $(document).on('click', '#btnBulkPrintProcessing', function() {
        var orderIds = [];

        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        if(orderIds.length > 0){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    
            $.ajax({
                url: './pos/processing/bulk/print',
                method: 'POST',
                data: { orderIds: orderIds },
                xhrFields: {
                    responseType: 'blob' // Important for file download
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    window.open(url, '_blank');
                },
                error: function() {
                    alert('Error generating the report.');
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
              })
        }

    });

});

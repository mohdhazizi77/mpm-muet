import $ from 'jquery'
window.jQuery = window.$ = $

$(document).ready(function() {

    if ($('#dt-user').length) {

        var table = $('#dt-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "./users/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
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
                    data: "name",
                    orderable: true,
                },
                {
                    data: "email",
                    orderable: false,
                },
                {
                    data: "phoneNum",
                    orderable: false,
                },
                {
                    data: "role",
                    orderable: true,
                    render(data, type, row) {

                        let html = '';
                        html = '<span class="badge bg-primary-subtle text-primary">'+data+'</span>';

                        return html;
                    }
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {

                        let html = '';

                        if (data == 0) { //active
                            html = '<span class="badge bg-success-subtle text-success">Active</span>';
                        } else {
                            html = '<span class="badge bg-danger-subtle text-danger">Inactive</span>';
                        }

                        return html;
                    }
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {
                        let isChecked = data === 0 ? 'checked' : '';

                        let html = '<div class="form-check form-switch form-switch-md d-flex justify-content-center align-items-center">' +
                                        '<input class="form-check-input" type="checkbox" role="switch" ' + isChecked + ' value="'+ data +'" id="toggleStatus">' +
                                    '</div>';

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
                        // btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#modalUpdatePos" ><i class="ri-information-line fs-22"></i></button>';

                        btn = '<button id="show_edit_modal" type="button" class="btn btn-soft-info waves-effect text-black mx-2" >' +
                                    ' <i class="ri-edit-line"></i>' +
                                    'EDIT' +
                                '</button>'

                        return btn;
                    }
                }
                // {
                //     data: "id",
                //     orderable: false,
                // },
                // {
                //     data: "id",
                //     orderable: false,
                //     render: function (data, type, row, meta) {

                //         var buttonCheckCert = '';
                //         var buttonPrintPDF = '';
                //         var buttonPrintMPM = '';

                //         console.log(data, row.is_more2year, row.is_selfPrintPaid, row.is_mpmPrintPaid);
                //         var modalSelf = 'modalVerifyPDF';
                //         var modalMPM = 'modalVerifyMPM';
                //         var modalPayment = 'modalPayment';

                //         if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             // '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '
                //             '<a href="/candidates-printmpm/'+data+'" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</a> '
                //         } else {
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalSelf+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</button> '
                //             // '<a href="/candidates-printmpm" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '

                //         }

                //         if (row.is_mpmPrintPaid ) {
                //             var buttonCheckCert =
                //             '<a href="/muet-status" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                //                 '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                //                 'CERTIFICATE STATUS' +
                //             '</a>'
                //         }

                //         return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                //     },
                //     // className: ,
                // }
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
        });

        $('#show_create_modal').on('click', function() {
            $('#modal_create').modal('show');
            $('.name').val('');
            $('.email').val('');
            $('.phonenumber').val('');
            $('.role').val('');
            $('.status').val('');
            $('#name_text').text('');
            $('#email_text').text('');
            $('#phone_text').text('');
            $('#role_text').text('');
            $('#status_text').text('');
            $('#form_users_add').removeClass('was-validated');

        });

        $(document).on('click', '#submit_add', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Clear previous validation messages
            $('.text-danger').text('');

            // Validate the form fields
            let isValid = true;

            // Name validation
            const name = $('#name').val().trim();
            if (name === '') {
                $('#name_text').text('Name is required.');
                isValid = false;
            }

            // Email validation
            const email = $('#email').val().trim();
            if (email === '') {
                $('#email_text').text('Email is required.');
                isValid = false;
            }

            // Phone Number validation
            const phonenumber = $('#phonenumber').val().trim();
            if (phonenumber === '') {
                $('#phone_text').text('Phone Number is required.');
                isValid = false;
            }

            // Role validation
            const role = $('select[name="role"]').val();
            if (role === null || role === '') {
                $('#role_text').text('Role is required.');
                isValid = false;
            }

            // Status validation
            const status = $('select[name="status"]').val();
            if (status === null || status === '') {
                $('#status_text').text('Status is required.');
                isValid = false;
            }

            // If the form is valid, proceed with SweetAlert confirmation and AJAX request
            if (isValid) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_users_add')[0]);

                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Users will be added!',
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
                            url: './users/store',
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
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response) {
                                Swal.close()
                                $('#form_users_add').removeClass('was-validated');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berjaya',
                                    text: 'User successfully added!',
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_create').modal('hide');
                                        $('#dt-user').DataTable().ajax.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, errors) {
                                $('#form_users_add').addClass('was-validated');
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    $('#name_text').text(xhr.responseJSON.errors.name ? xhr.responseJSON.errors.name[0] : '');
                                    $('#email_text').text(xhr.responseJSON.errors.email ? xhr.responseJSON.errors.email[0] : '');
                                    $('#phone_text').text(xhr.responseJSON.errors.phonenumber ? xhr.responseJSON.errors.phonenumber[0] : '');
                                    $('#role_text').text(xhr.responseJSON.errors.role ? xhr.responseJSON.errors.role[0] : '');
                                    $('#status_text').text(xhr.responseJSON.errors.status ? xhr.responseJSON.errors.status[0] : '');

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
            }
        });

        $(document).on('click', '#show_edit_modal', function(e) {
            e.preventDefault();

            $('#name_text_edit').text('');
            $('#email_text_edit').text('');
            $('#phone_text_edit').text('');
            $('#role_text_edit').text('');
            $('#status_text_edit').text('');
            $('#form_users_edit').removeClass('was-validated');

            var rowData = table.row($(this).parents('tr')).data();
            $('#form_users_edit [name="id"]').val(rowData.id);
            $('#form_users_edit [name="name"]').val(rowData.name);
            $('#form_users_edit [name="email"]').val(rowData.email);
            $('#form_users_edit [name="phonenumber"]').val(rowData.phoneNum);
            $('#form_users_edit [name="role"]').val(rowData.role);
            $('#form_users_edit [name="status"]').val(rowData.status);

            $('#modal_edit').modal('show');
        })

        $(document).on('click', '#submit', function(e) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData($('#form_users_edit')[0]);

            const id = $('#id').val();

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Users will be updated!',
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
                        url: './users/update/' + id,
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
                            Swal.close()
                            $('#form_users_edit').removeClass('was-validated');
                            Swal.fire({
                                type: 'success',
                                title: 'Berjaya',
                                text: 'User successfully updated!',
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            }).then((result) => {
                                if (result.value) {
                                    $('#modal_edit').modal('hide');
                                    $('#dt-user').DataTable().ajax.reload();
                                }
                            });
                        },
                        error: function(xhr, status, errors) {
                            $('#form_users_edit').addClass('was-validated');
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $('#name_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.name ? xhr.responseJSON.errors.name[0] : '');
                                $('#email_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.email ? xhr.responseJSON.errors.email[0] : '');
                                $('#phone_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.phonenumber ? xhr.responseJSON.errors.phonenumber[0] : '');
                                $('#role_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.role ? xhr.responseJSON.errors.role[0] : '');
                                $('#status_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.status ? xhr.responseJSON.errors.status[0] : '');

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

        $(document).on('click', '#toggleStatus', function(e) {
            e.preventDefault();
            var rowData = table.row($(this).parents('tr')).data();
            if(rowData.status == 0){
                deactive(rowData.id);
            }else{
                active(rowData.id);
            }
        })
    }

    $('#new-password').on('keyup', function() {
        validatePasswords();
    });

    // Bind the change event for the confirm password input
    $('#confirm-password').on('keyup', function() {
        validatePasswords();
    });

    // Function to validate the passwords
    function validatePasswords() {
        var newPassword = $('#new-password').val();
        var confirmPassword = $('#confirm-password').val();
        var passwordErrorDiv = $('#password-error');

        // Password requirements
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        var isLengthValid = newPassword.length >= 8;
        var hasLowercase = /[a-z]/.test(newPassword);
        var hasUppercase = /[A-Z]/.test(newPassword);
        var hasNumber = /\d/.test(newPassword);

        if (newPassword === '' && confirmPassword === '') {
            // Both fields are blank, enable the submit button
            passwordErrorDiv.hide();
            $('button[type="submit"]').prop('disabled', false);
          } else if (newPassword !== confirmPassword) {
            passwordErrorDiv.text("Passwords do not match.").show();
            $('button[type="submit"]').prop('disabled', true);
          } else if (!isLengthValid) {
            passwordErrorDiv.text("Password must be at least 8 characters long.").show();
            $('button[type="submit"]').prop('disabled', true);
          } else if (!hasLowercase) {
            passwordErrorDiv.text("Password must contain at least one lowercase letter.").show();
            $('button[type="submit"]').prop('disabled', true);
          } else if (!hasUppercase) {
            passwordErrorDiv.text("Password must contain at least one uppercase letter.").show();
            $('button[type="submit"]').prop('disabled', true);
          } else if (!hasNumber) {
            passwordErrorDiv.text("Password must contain at least one number.").show();
            $('button[type="submit"]').prop('disabled', true);
          } else {
            passwordErrorDiv.hide();
            $('button[type="submit"]').prop('disabled', false);
          }

        $('button[type="submit"]').prop('disabled', passwordErrorDiv.is(':visible'));
    }

});

function active(id){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'Users will be Activate!',
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
                url: './users/actived/' + id,
                method: 'POST',
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
                    Swal.close()
                    $('#form_users_edit').removeClass('was-validated');
                    Swal.fire({
                        type: 'success',
                        title: 'Berjaya',
                        text: 'User successfully Activated!',
                        customClass: {
                            popup: 'my-swal-popup',
                            confirmButton: 'my-swal-confirm',
                            cancelButton: 'my-swal-cancel',
                        }
                    }).then((result) => {
                        if (result.value) {
                            $('#dt-user').DataTable().ajax.reload();
                        }
                    });
                },
                error: function(xhr, status, errors) {
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
}

function deactive(id){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'Users will be Deactive!',
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
                url: './users/deactived/' + id,
                method: 'POST',
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
                    Swal.close()

                    $('#form_users_edit').removeClass('was-validated');
                    Swal.fire({
                        type: 'success',
                        title: 'Success',
                        text: 'User successfully Deactived!',
                        customClass: {
                            popup: 'my-swal-popup',
                            confirmButton: 'my-swal-confirm',
                            cancelButton: 'my-swal-cancel',
                        }
                    }).then((result) => {
                        if (result.value) {
                            $('#dt-user').DataTable().ajax.reload();
                        }
                    });
                },
                error: function(xhr, status, errors) {
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
}

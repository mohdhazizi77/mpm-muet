@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
@endsection
@section('css')
    <style>
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }

            .card {
                padding: 15px;
            }

            .text-center img {
                width: 80%;
                margin: 0 auto;
            }

            .btn {
                width: 100%; /* Make buttons full width */
            }
        }

        /* Smaller Screens */
        @media (max-width: 480px) {
            .container {
                padding: 0 5px;
            }

            .text-center img {
                width: 100%;
            }

            .btn {
                width: 100%; /* Make buttons full width */
            }
        }

        .input-group-append {
            cursor: pointer;
        }

        #toggle-password-icon.ri-eye-line,
        #toggle-password-icon.ri-eye-close-line {
            transition: transform 1s ease;
        }
    </style>
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                     viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-3 mb-4 text-white-50">
                            <div>
                                <a href="index" class="d-inline-block auth-logo">
                                    <img src="{{ URL::asset('build/images/mpm-logo.png') }}" alt="" height="100">
                                </a>
                            </div>
                            <a href="index" class="d-inline-block auth-logo">
                                <img src="{{ URL::asset('build/images/muet-text-long-black.png') }}" alt="" height="60">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h3 class="text-primary">MUET Online Certificate System</h3>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="form_verify_password" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="password" name="password" type="password" placeholder="Enter password"
                                                       class="form-control @error('password') is-invalid @enderror" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="toggle-password">
                                                        <i class="ri-eye-close-line" id="toggle-password-icon"></i>
                                                    </span>
                                                </div>
                                            </div>                                            
                                            <span id="password_text" class="text-danger"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input id="password_confirmation" name="password_confirmation" type="password"  placeholder="Enter password"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                            <span id="password_confirmation_text" class="text-danger"></span>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="invalid-feedback" id="passwordMatchError" style="display: none;">
                                            <strong>Passwords do not match.</strong>
                                        </div>
                                    </form>
                                    <div class="mt-4">
                                        <button class="btn btn-soft-success btn-border w-md float-end" type="submit" id="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
@endsection
@section('script')
    <script>
         $(document).ready(function() {
            $(document).on('click', '#submit', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_verify_password')[0]);
                const id = @json($id);

                $.ajax({
                    url: '/users/verify-password/' + id + '/update',
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
                                Swal.showLoading(Swal.getDenyButton());
                            }
                        });
                    },
                    success: function(response) {
                        $('#form_verify_password').removeClass('was-validated');
                        Swal.fire({
                            type: 'success',
                            title: 'Success',
                            text: 'Password already been saved!',
                            customClass: {
                                popup: 'my-swal-popup',
                                confirmButton: 'my-swal-confirm',
                                cancelButton: 'my-swal-cancel',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('admin.login') }}';
                            }
                        });
                    },
                    error: function(xhr, status, errors) {
                        $('#form_verify_password').addClass('was-validated');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            if (xhr.responseJSON.errors && xhr.responseJSON.errors.password) {
                                $('#password').addClass('is-invalid');
                                $('#password_confirmation').addClass('is-invalid');
                                $('#password_text').text(xhr.responseJSON.errors.password[0]);
                                $('#password_confirmation_text').text(xhr.responseJSON.errors.password[0]);
                            }

                            Swal.fire({
                                icon: "error",
                                title: 'Fail',
                                text: xhr.responseJSON.message,
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: 'Fail',
                                text: xhr.responseText,
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            });
                        }
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordMatchError = document.getElementById('passwordMatchError');

            function validatePasswordMatch() {
                if(passwordConfirmation.value){
                    if (password.value !== passwordConfirmation.value) {
                        passwordConfirmation.classList.add('is-invalid');
                        passwordMatchError.style.display = 'block';
                    } else {
                        passwordConfirmation.classList.remove('is-invalid');
                        passwordMatchError.style.display = 'none';
                    }
                }else{
                    passwordConfirmation.classList.remove('is-invalid');
                    passwordMatchError.style.display = 'none';
                }
            }

            password.addEventListener('input', validatePasswordMatch);
            passwordConfirmation.addEventListener('input', validatePasswordMatch);


            const togglePassword = document.getElementById('toggle-password');
            const togglePasswordIcon = document.getElementById('toggle-password-icon');

            togglePassword.addEventListener('click', function () {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the eye icon
                togglePasswordIcon.classList.toggle('ri-eye-line');
                togglePasswordIcon.classList.toggle('ri-eye-close-line');
            });
        });

    </script>
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection

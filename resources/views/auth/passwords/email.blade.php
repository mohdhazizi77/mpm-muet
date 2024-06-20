@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.password-reset')
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
                                <img src="{{ URL::asset('build/images/muet-text-long-black.png') }}" alt=""
                                    height="60">
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
                                    <h5 class="text-primary">Forgot Password?</h5>
                                    <p class="text-muted">Reset password with velzon</p>

                                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                        colors="primary:#0ab39c" class="avatar-xl">
                                    </lord-icon>

                                </div>

                                <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                    Enter your email and instructions will be sent to you!
                                </div>
                                <div class="p-2">
                                    {{-- @if (session('status'))
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif --}}
                                    <form class="form-horizontal" id="form_check_email" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="useremail" name="email" placeholder="Enter email"
                                                value="{{ old('email') }}" id="email" required>
                                            <span id="email_text" class="text-danger"></span>
                                            {{-- @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="button"
                                                id="submit">Reset</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="{{ route('login') }}"
                                    class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        {{-- <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#submit', function(e) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData($('#form_check_email')[0]);

                $.ajax({
                    url: '{{ route('users.verify_email') }}',
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
                        $('#form_check_email').removeClass('was-validated');
                        Swal.fire({
                            type: 'success',
                            title: 'Success',
                            text: 'Please check your email to renew your password!',
                            customClass: {
                                popup: 'my-swal-popup',
                                confirmButton: 'my-swal-confirm',
                                cancelButton: 'my-swal-cancel',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('admin.login') }}/';
                            }
                        });
                    },
                    error: function(xhr, status, errors) {
                        $('#form_check_email').addClass('was-validated');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
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
                            $('#useremail').addClass('is-invalid');
                            $('#email_text').text(xhr.responseText);
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
    </script>
    <script src="{{ URL::asset('build/js/pages/eva-icon.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection

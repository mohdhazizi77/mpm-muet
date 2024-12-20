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
                            <a href="index" class="text-center auth-logo">
                                {{-- <img src="{{ URL::asset('build/images/muet-text-long-black.png') }}" alt="" height="60"> --}}
                                <b><h1 style="font-size: 22pt;font-weight: bolder;color: black;">MALAYSIAN UNIVERSITY ENGLISH TEST</h1></b>
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
                                @if (session('fail'))
                                    <div id="failMessage" class="alert alert-danger">
                                        {{ session('fail') }}
                                    </div>
                                @endif
                                <div class="p-2 mt-4">
                                    <form action="{{ route('admin.login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input id="email" name="email" type="text" value="{{ old('email') }}" placeholder="Enter email"
                                                   class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{ route('password.update') }}" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password"
                                                       class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                       name="password" placeholder="Enter password" id="password-input">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-soft-success btn-border w-md float-end" type="submit">Log In</button>
                                        </div>

                                    </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the success message exists
            const failMessage = document.getElementById('failMessage');
            if (failMessage) {
                // Hide the success message after 5 seconds
                setTimeout(function() {
                    failMessage.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection

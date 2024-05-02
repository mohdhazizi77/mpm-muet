@extends('layouts.master-without-nav')
@section('title')
    Daftar Masuk
@endsection
@section('content')

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">

                                            <div class="mb-4">
                                                <a href="index" class="d-block">
                                                    <img src="{{ URL::asset('build/images/muet-text.png') }}" alt="" height="40">
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Selamat Datang !</h5>
                                            <p class="text-muted">Sila masukkan No. Kad Pengenalan / No. Pasport.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="index">

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">No. Kad Pengenalan/No. Pasport</label>
                                                    <input type="text" class="form-control" id="username"
                                                           placeholder="">
                                                </div>

                                                {{--                                                <div class="mb-3">--}}
                                                {{--                                                    <div class="float-end">--}}
                                                {{--                                                        <a href="auth-pass-reset-cover" class="text-muted">Forgot--}}
                                                {{--                                                            password?</a>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <label class="form-label" for="password-input">Password</label>--}}
                                                {{--                                                    <div class="position-relative auth-pass-inputgroup mb-3">--}}
                                                {{--                                                        <input type="password" class="form-control pe-5 password-input"--}}
                                                {{--                                                               placeholder="Enter password" id="password-input">--}}
                                                {{--                                                        <button--}}
                                                {{--                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"--}}
                                                {{--                                                            type="button" id="password-addon"><i--}}
                                                {{--                                                                class="ri-eye-fill align-middle"></i></button>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}

                                                {{--                                                <div class="form-check">--}}
                                                {{--                                                    <input class="form-check-input" type="checkbox" value=""--}}
                                                {{--                                                           id="auth-remember-check">--}}
                                                {{--                                                    <label class="form-check-label" for="auth-remember-check">Remember--}}
                                                {{--                                                        me</label>--}}
                                                {{--                                                </div>--}}

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Daftar Masuk</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            Sistem Semakan Keputusan Sijil MUET
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection

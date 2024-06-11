@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Error_403')
@endsection

@section('body')
    <body>
    @endsection
    @section('content')
        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->


            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center pt-4">
                                <div class="">
                                    <img src="{{ URL::asset('build/images/error.svg') }}" alt="" height="350" class="error-basic-img move-animation">
                                </div>
                                <div class="mt-n4">
                                    <h1 class="display-1 fw-medium">403</h1>
                                    <h3 class="text-uppercase">Harap Maaf!</h3>
                                    <p class="text-muted mb-4">Anda tidak mempunyai kebenaran untuk melihat sumber atau halaman ini menggunakan akaun anda.</p>
                                    <a href="/login" class="btn btn-success"></i>Log Masuk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->


        </div>
        <!-- end auth-page-wrapper -->

    @endsection
    @section('script')
        <!-- particles js -->
        <script src="{{ URL::asset('build/libs/particles.js/particles.js.min.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
@endsection

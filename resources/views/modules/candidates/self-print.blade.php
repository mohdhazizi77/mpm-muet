@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n4 border-top">
                    @if(Session::has('error'))
                        <div class="alert alert-danger mb-3">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold">CANDIDATE'S DETAILS</h3>
                                    <table class="table-borderless fs-16 mt-3 fw-bold">
                                        <tr>
                                            <td>NAME</td>
                                            <td class="px-2">:</td>
                                            <td>{{ $candidate->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>IDENTIFICATION CARD NUMBER</td>
                                            <td class="px-2">:</td>
                                            <td>{{ $candidate->kp }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!--end col-->
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">

                    <div class="card-header bg-dark-subtle">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title mb-0 fs-20 fw-bolder">Payment Information</h5>
                                <p class="text-muted mb-0">Please fill all information below</p>
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="px-4">
                        <div class="row">
                            <div class="col-xl-12">


                                <div class="py-4">

                                    <form id="paymentForm" method="POST" action="{{ route('candidate.makepayment') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter your name" id="name" readonly  name="name" value="{{ $candidate->nama }}">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="icNumber" class="form-label">Identification Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter your identification card number" id="icNumber" name="nric" readonly  value="{{ $candidate->kp }}">
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Phone Number</label>
                                                <div class="input-group" data-input-flag>
                                                    <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{URL::asset('build/images/flags/my.svg')}}" alt="flag img" height="20"
                                                                                                                                                            class="country-flagimg rounded"><span class="ms-2 country-codeno">+60</span></button>
                                                    <input name="phone_num" type="text" value="{{ old('phone_num') }}" class="form-control rounded-end flag-input" value="" required placeholder="Enter your phone number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                                    <div class="dropdown-menu w-100">
                                                        <div class="p-2 px-3 pt-1 searchlist-input">
                                                            <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..."/>
                                                        </div>
                                                        <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" name="email" id="email" required>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                        <input name="pay_for" value="SELF_PRINT" type="text" style="display: none">
                                        <input name="crypt_id" value="{{ $candidate->cryptId }}" type="text" style="display: none">
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col-->
        </div>

        <div>

            <x-button.back></x-button.back>
            <a id="button-payment" href="#" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">
                <i class="ri-secure-payment-fill label-icon align-middle fs-16 me-2"></i>PROCEED TO PAYMENT</a>

        </div>


    </div>
@endsection
@section('script')

    <script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#button-payment').on('click', function(e) {
                e.preventDefault(); // Prevent the default action of the link
                // Update form action based on your logic
                $('#paymentForm').attr('action', '{{ route('candidate.makepayment') }}');
                // Submit the form
                $('#paymentForm').submit();
            });
        });
    </script>

@endsection

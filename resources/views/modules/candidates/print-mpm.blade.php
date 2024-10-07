@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')
    <style>
        .button-container {
            display: flex;
            justify-content: space-between; /* Ensure buttons are spaced apart */
            align-items: center; /* Vertically align buttons */
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
            gap: 10px; /* Gap between buttons */
        }

        /* Media queries for mobile screens */
        @media (max-width: 767px) {
            .button-container {
                flex-direction: column; /* Stack buttons vertically on small screens */
                align-items: stretch; /* Stretch buttons to fit container width */
            }
        }
    </style>
@endsection

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n2 border-top">
                    <div class="px-4">
                        <div class="row">
                            @if(Session::has('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold fs-15">CANDIDATE'S DETAILS</h3>
                                    <div style="overflow-x:auto;">
                                        <table class="table-borderless fs-14 mt-2 fw-bold">
                                            <tr>
                                                <td width=40%>NAME</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width=40%>IDENTIFICATION CARD NUMBER</td>
                                                <td class="px-2">:</td>
                                                <td class="">{{ $user->identity_card_number }}</td>
                                            </tr>
                                        </table>
                                    </div>
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

        @if ($show_result)
        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="py-4">
                                    <table class="table table-borderless text-center">
                                        <div class="clearfix">
                                            <h5 class="py-2 fw-bold float-start">{{ $result['session'] }}</h5>
                                            <h5 class="py-2 fw-bold float-end">{{ $result['index_number'] }}</h5>
                                        </div>
                                        <thead>
                                        <tr class="text-center bg-dark-subtle border-1 border-black">
                                            <th scope="col" class="w-25 border-1 border-black">TEST COMPONENT</th>
                                            <th scope="col" class="w-25 border-1 border-black">MAXIMUM SCORE</th>
                                            <th scope="col" class="w-25 border-1 border-black">OBTAINED SCORE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="align-middle ">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">LISTENING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['listening'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['listening'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">SPEAKING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['speaking'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['speaking'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">READING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['reading'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['reading'] }}</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">WRITING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $scheme['writing'] }}</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">{{ $result['writing'] }}</td>
                                        </tr>
                                        <tr class="align-middle fw-bold">
                                            <td class="border-black border-1">AGGREGATED SCORE</td>
                                            <td class="border-black border-1">{{ $scheme['agg_score'] }}</td>
                                            <td class="border-black border-1">{{ $result['agg_score'] }}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-borderless text-center">
                                        <tbody>
                                        <tr class="align-middle fw-bold pt-3">
                                            <td class="w-25 hidden"></td>
                                            <td class="w-25 text-end">BAND ACHIEVED</td>
                                            <td class="w-25 bg-dark-subtle border-1 border-black">{{ $result['band'] }}</td>
                                        </tr>
                                        </tbody>
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
        @endif

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
                            <div class="col-12">
                                <h5 class="card-title mb-0 fs-20 fw-bolder">Shipping Information</h5>
                                <p class="text-muted mb-0">All fields are mandatory</p>
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
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter your name" name="name" readonly value="{{ $user->name }}">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="icNumber" class="form-label">Identification Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter your identification card number" id="icNumber" name="nric" readonly value="{{ $user->identity_card_number }}">
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <label class="form-label">Phone Number</label>
                                                <div class="input-group" data-input-flag>
                                                    <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{URL::asset('build/images/flags/my.svg')}}" alt="flag img" height="20"
                                                                                                                                                            class="country-flagimg rounded"><span class="ms-2 country-codeno">+60</span></button>
                                                    <input name="phone_num" type="text" value="{{ old('phone_num') }}" class="form-control rounded-end flag-input" placeholder="Enter your phone number"
                                                           oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                                                    <div class="dropdown-menu w-100">
                                                        <div class="p-2 px-3 pt-1 searchlist-input">
                                                            <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..."/>
                                                        </div>
                                                        <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" placeholder="Enter your email" value="{{ old('email') }}"  name="email">
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                        <div class="row">

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" placeholder="Enter your address" name="address" value="{{ old('address') }}">
                                                </div>
                                            </div><!--end col-->

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="postcode" class="form-label">Postcode</label>
                                                    <input type="text" class="form-control" placeholder="Enter your postcode" name="postcode" value="{{ old('postcode') }}">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-4 col-sm-6">
                                                <div class="mb-3">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" placeholder="Enter your city" name="city" value="{{ old('city') }}">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-4 col-sm-6">
                                                <div class="mb-3">
                                                    <label for="state" class="form-label">State</label>
                                                    <select class="form-select mb-3" aria-label="Default select example" name="state">
                                                        <option value="" disabled selected>Select your state</option>
                                                        @foreach (App\Models\User::getStates() as $key => $value)
                                                            <option value="{{ $key }}" @if(old('state') == $key) selected @endif>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><!--end col-->

                                            <div class="mt-4">
                                                <label for="shippingMethod" class="form-label">Order Details</label>

                                                <div class="row g-4">
                                                    @foreach ($couriers as $key => $value)
                                                    <div class="col-lg-4">
                                                        <div class="form-check card-radio">
                                                            <input id="shippingMethod{{ $key }}" name="courier" value="{{ $key+1 }}" type="radio" class="form-check-input" checked>
                                                            <label class="form-check-label" for="shippingMethod{{ $key }}">
                                                                {{-- <span class="fs-20 float-end mt-2 text-wrap d-block fw-semibold">RM {{ $value->rate }}</span> --}}
                                                                {{-- <span class="fs-20 float-end mt-2 text-wrap d-block fw-semibold">RM {{ number_format($value->rate, 2) }}</span> --}}
                                                                <span class="fs-20 mt-2 text-wrap d-block">{{ $value->name }}</span>
                                                                <table>
                                                                    <tr>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block">Estimated delivery period</span></td>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block px-2">:</span></td>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block">{{ $value->duration }}</span></td>
                                                                    </tr>
                                                                </table>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <input name="pay_for" value="MPM_PRINT" type="text" style="display: none">
                                        <input name="crypt_id" value="{{ $cryptId }}" type="text" style="display: none">
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

        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">

                    <div class="card-header bg-dark-subtle">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title mb-0 fs-20 fw-bolder">Order Information</h5>
                                <p class="text-muted mb-0">Kindly verify your order information</p>
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="px-4">
                        <div class="row">
                            <div class="col-xl-12">


                                <div class="py-4">
                                    <div class="row" style="padding: 10px">
                                        <div class="col" style="text-align: left">
                                            MUET Certificate ({{ $result['session'] }})
                                        </div>
                                        <div class="col" style="text-align: right">
                                            RM {{ number_format($config->rate_mpmprint, 2) }}
                                        </div>
                                    </div>
                                    <div class="row mt-3" style="padding: 10px">
                                        <div class="col" style="text-align: left">
                                            Delivery charges
                                        </div>
                                        <div class="col" style="text-align: right">
                                            RM {{ number_format(0, 2) }}
                                        </div>
                                    </div>
                                    <div class="row mt-3" style="background-color: rgb(227, 227, 227);padding: 10px;font-weight: bolder">
                                        <div class="col" style="text-align: left">
                                            Total
                                        </div>
                                        <div class="col" style="text-align: right">
                                            RM {{ number_format(($config->rate_mpmprint), 2) }}
                                        </div>
                                    </div>
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

        <div class="button-container row">
            <!-- Back button: Stack vertically on small screens -->
            <div class="col-12 col-md-auto mb-2 mb-md-0">
                <x-button.back></x-button.back>
            </div>

            <!-- Payment button: Stack vertically on small screens -->
            <div class="col-12 col-md-auto">
                <a id="button-payment" href="#" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-100">
                    <i class="ri-secure-payment-fill label-icon align-middle fs-16 me-2"></i>PROCEED TO PAYMENT
                </a>
            </div>
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

            $('input[name="phone_num"]').on('change', function() {
                // Get the current value of the input field
                var phoneNumber = $(this).val();

                // Check if the phone number starts with '0' and remove it
                if (phoneNumber.startsWith('0')) {
                    phoneNumber = phoneNumber.substring(1);
                }

                // Set the modified phone number back to the input field
                $(this).val(phoneNumber);
            });
        });
    </script>

@endsection

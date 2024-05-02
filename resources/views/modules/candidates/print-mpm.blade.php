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

                @if($status == 'FAILED')

                    <div class="card rounded-0 {{ $status == 'SUCCESS' ? 'bg-success-subtle' : 'bg-danger' }}  mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-6 align-self-center">
                                    <div class="py-3">
                                        <h3 class="fw-bold">PAYMENT {{ $status }}!</h3>
                                        <table class="table-borderless fs-16 mt-3">
                                            <tr>
                                                <td class="fw-bold">
                                                    TRANSACTION REFERENCE : {{ $txn_id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>The payment was unsuccessful. Please try again or use another payment method.</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{--                        <div class="col-xxl-3 ms-auto">--}}
                                {{--                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">--}}
                                {{--                                <img src="{{ URL::asset('build/images/faq-img.png') }}" alt="" class="img-fluid">--}}
                                {{--                            </div>--}}
                                {{--                        </div>--}}
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>

                    <br>

                @endif

                <div class="card rounded-0 bg-success-subtle mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold">CANDIDATE'S DETAILS</h3>
                                    <table class="table-borderless fs-16 mt-3 fw-bold">
                                        <tr>
                                            <td>NAME</td>
                                            <td class="px-2">:</td>
                                            <td>ALI BIN ABU</td>
                                        </tr>
                                        <tr>
                                            <td>IDENTIFICATION CARD NUMBER</td>
                                            <td class="px-2">:</td>
                                            <td>900101121357</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            {{--                        <div class="col-xxl-3 ms-auto">--}}
                            {{--                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">--}}
                            {{--                                <img src="{{ URL::asset('build/images/faq-img.png') }}" alt="" class="img-fluid">--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
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
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="py-4">
                                    {{--                                <h2 class="display-8 coming-soon-text text-success">TEST LIST</h2>--}}
                                    <!-- Striped Rows -->
                                    <table class="table table-borderless text-center">
                                        <div class="clearfix">
                                            <h4 class="py-2 fw-bold float-start">SESSION 3, 2023</h4>
                                            <h4 class="py-2 fw-bold float-end">MA2011/0201</h4>
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
                                            <td class="border-black border-1 border-top-0 border-bottom-0">90</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">45</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">SPEAKING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">90</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">41</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">READING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">90</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">65</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td class="border-black border-1 border-top-0 border-bottom-0">WRITING</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">90</td>
                                            <td class="border-black border-1 border-top-0 border-bottom-0">30</td>
                                        </tr>
                                        <tr class="align-middle fw-bold">
                                            <td class="border-black border-1">AGGREGATED SCORE</td>
                                            <td class="border-black border-1">360</td>
                                            <td class="border-black border-1">181</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-borderless text-center">
                                        <tbody>
                                        <tr class="align-middle fw-bold pt-3">
                                            <td class="w-25 hidden"></td>
                                            <td class="w-25 text-end">BAND ACHIEVED</td>
                                            <td class="w-25 bg-dark-subtle border-1 border-black">3.5</td>
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

        <div class="row pt-3">
            <div class="col-lg-12">
                <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">

                    <div class="card-header bg-dark-subtle">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title mb-0 fs-20 fw-bolder">Shipping Information</h5>
                                <p class="text-muted mb-0">Please fill all information below</p>
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="px-4">
                        <div class="row">
                            <div class="col-xl-12">


                                <div class="py-4">

                                    <form action="javascript:void(0);">

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter your name" id="name" value="ALI BIN ABU">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="icNumber" class="form-label">Identification Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter your identification card number" id="icNumber" value="900101121357">
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Phone Number</label>
                                                <div class="input-group" data-input-flag>
                                                    <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{URL::asset('build/images/flags/my.svg')}}" alt="flag img" height="20"
                                                                                                                                                            class="country-flagimg rounded"><span class="ms-2 country-codeno">+60</span></button>
                                                    <input type="text" class="form-control rounded-end flag-input" value="" placeholder="Enter your phone number"
                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
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
                                                    <input type="text" class="form-control" placeholder="Enter your email" id="email">
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                        <div class="row">

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" placeholder="Enter your address" id="address">
                                                </div>
                                            </div><!--end col-->

                                        </div>

                                        <div class="row">

                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="postcode" class="form-label">Postcode</label>
                                                    <input type="text" class="form-control" placeholder="Enter your postcode" id="postcode">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" placeholder="Enter your city" id="city">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="state" class="form-label">State</label>
                                                    <select class="form-select mb-3" aria-label="Default select example">
                                                        <option disabled selected>Select your state</option>
                                                        <option value="1">JOHOR</option>
                                                        <option value="2">KEDAH</option>
                                                        <option value="3">KELANTAN</option>
                                                        <option value="4">MELAKA</option>
                                                        <option value="5">NEGERI SEMBILAN</option>
                                                        <option value="6">PAHANG</option>
                                                        <option value="7">PERAK</option>
                                                        <option value="8">PERLIS</option>
                                                        <option value="9">PULAU PINANG</option>
                                                        <option value="10">SABAH</option>
                                                        <option value="11">SARAWAK</option>
                                                        <option value="12">SELANGOR</option>
                                                        <option value="13">TERENGGANU</option>
                                                        <option value="14">WILAYAH PERSEKUTUAN KUALA LUMPUR</option>
                                                        <option value="15">WILAYAH PERSEKUTUAN LABUAN</option>
                                                        <option value="16">WILAYAH PERSEKUTUAN PUTRAJAYA</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->

                                            <div class="mt-4">
                                                <label for="shippingMethod" class="form-label">Order Details</label>

                                                <div class="row g-4">
                                                    <div class="col-lg-4">
                                                        <div class="form-check card-radio">
                                                            <input id="shippingMethod01" name="shippingMethod" type="radio" class="form-check-input" checked>
                                                            <label class="form-check-label" for="shippingMethod01">
                                                                <span class="fs-20 float-end mt-2 text-wrap d-block fw-semibold">RM60.00</span>
                                                                <span class="fs-20 mt-2 text-wrap d-block">MUET Certificate</span>
                                                                <table>
                                                                    {{--                                                                    <tr>--}}
                                                                    {{--                                                                        <td><span class="text-muted fw-normal text-wrap d-block">Certificate</span></td>--}}
                                                                    {{--                                                                        <td><span class="text-muted fw-normal text-wrap d-block px-2">:</span></td>--}}
                                                                    {{--                                                                        <td><span class="text-muted fw-normal text-wrap d-block">RM60.00</span></td>--}}
                                                                    {{--                                                                    </tr>--}}
                                                                    <tr>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block">Courier</span></td>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block px-2">:</span></td>
                                                                        <td><span class="text-muted fw-normal text-wrap d-block">POS Laju</span></td>
                                                                    </tr>
                                                                </table>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


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
            {{--            <x-button.payment></x-button.payment>--}}
            <a id="button-payment" href="{{ route('candidates.payment') }}" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">
                <i class="ri-secure-payment-fill label-icon align-middle fs-16 me-2"></i>PROCEED TO PAYMENT</a>

        </div>


    </div>
@endsection
@section('script')

    <script src="{{URL::asset('build/js/pages/flag-input.init.js')}}"></script>

    <script>
        $(document).ready(function () {

            $('#button-payment').on('click', function (e) {

                e.preventDefault();

                // let selectedState = $('#state').val();
                // let selectedType = $('#type').val();
                // let selectedCollege = $('#collegeAll').val();
                // let selectedYear = $('#year').val();
                // let selectedSemester = $('#semester').val();
                // let selectedCourse = $('#courseAll').val();

                let action = $(this).attr('href')
                // let url = action + '?state=' + selectedState +
                //     '&type=' + selectedType +
                //     '&college=' + selectedCollege +
                //     '&year=' + selectedYear +
                //     '&semester=' + selectedSemester +
                //     '&course=' + selectedCourse;

                let url = action;
                window.location.href = url;
            })

        })
    </script>

@endsection

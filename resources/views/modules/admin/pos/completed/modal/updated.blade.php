{{--MODAL UPDATE POS--}}
<div class="modal fade modalUpdatePos" id="modalUpdatePos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"></button>
            </div>
            <div class="container">
                <div class="row mx-3">
                    <div class="col-xl-12">


                        <div class="row pt-3">
                            <div class="col-lg-12">
                                <div class="card rounded-0 bg-white mx-n4 border-top">

                                    <div class="card-header bg-dark-subtle">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title mb-0 fs-20 fw-bolder">Candidate's Information</h5>
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
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your name" id="name" name="name" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="icNumber" class="form-label">Identification Card Number</label>
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your identification card number" id="nric" name="nric" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->

                                                        {{-- <div class="row">
                                                            <div class="col-6">
                                                                <label class="form-label">Phone Number</label>
                                                                <div class="input-group" data-input-flag>
                                                                    <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                            src="{{URL::asset('build/images/flags/my.svg')}}"
                                                                            alt="flag img" height="20"
                                                                            class="country-flagimg rounded"><span
                                                                            class="ms-2 country-codeno">+60</span></button>
                                                                    <input disabled type="text" class="form-control rounded-end flag-input" value="" placeholder="Enter your phone number" name
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
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your email" id="email" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row--> --}}

                                                        {{-- <div class="row">

                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label for="address" class="form-label">Address</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your address" id="address" name="address" value="">
                                                                </div>
                                                            </div>

                                                        </div> --}}

                                                        {{-- <div class="row">

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="postcode" class="form-label">Postcode</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your postcode" id="postcode" name="postcode" value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="city" class="form-label">City</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your city" id="city" name="city" value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="state" class="form-label" >State</label>
                                                                    <select readonly class="form-select mb-3" id="state"  disabled>
                                                                        <option selected disabled>Select State</option>
                                                                        @foreach (App\Models\User::getStates() as $key => $value)
                                                                            <option value="{{ $key }}" @if(old('state') == $key) selected @endif>{{ $value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div> --}}

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

                        <div class="row shipping_info">
                            <div class="col-lg-12">
                                <div class="card rounded-0 bg-white mx-n4 border-top">

                                    <div class="card-header bg-dark-subtle">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title mb-0 fs-20 fw-bolder">Shipping Information</h5>
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
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your name" id="ship_name" name="ship_name" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="ship_phoneNum" class="form-label">Phone Number</label>
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your phone_number" id="ship_phoneNum" name="ship_phoneNum" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->

                                                        <div class="row">
                                                            {{-- <div class="col-6">
                                                                <label class="form-label">Phone Number</label>
                                                                <div class="input-group" data-input-flag>
                                                                    <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                            src="{{URL::asset('build/images/flags/my.svg')}}"
                                                                            alt="flag img" height="20"
                                                                            class="country-flagimg rounded"><span
                                                                            class="ms-2 country-codeno">+60</span></button>
                                                                    <input disabled type="text" class="form-control rounded-end flag-input"  placeholder="Enter your phone number" value=""
                                                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                                                    <div class="dropdown-menu w-100">
                                                                        <div class="p-2 px-3 pt-1 searchlist-input">
                                                                            <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..."/>
                                                                        </div>
                                                                        <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <input disabled type="text" class="form-control" placeholder="Enter your email" id="ship_email" name="ship_email" value="">
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->

                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label for="address" class="form-label">Address</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your address" id="ship_address" name="ship_address" value="">
                                                                </div>
                                                            </div><!--end col-->

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="postcode" class="form-label">Postcode</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your postcode" id="ship_postcode" name="ship_postcode" value="">
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="city" class="form-label">City</label>
                                                                    <input disabled  type="text" class="form-control" placeholder="Enter your city" id="ship_city" name="ship_city" value="">
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="state" class="form-label" >State</label>
                                                                    <select readonly class="form-select mb-3" id="ship_state" disabled name="ship_state">
                                                                        <option selected disabled>Select State</option>
                                                                        @foreach (App\Models\User::getStates() as $key => $value)
                                                                            <option value="{{ $key }}" @if(old('state') == $key) selected @endif>{{ $value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="track_num" class="form-label">Tracking Number</label>
                                                                    <input type="text" class="form-control" placeholder="Enter tracking number" id="ship_trackNum" name="ship_trackNum" value="" disabled>
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <label for="track_remarks" class="form-label">Notes</label>
                                                                    <input type="text" class="form-control" placeholder="" id="ship_trackRemarks" name="ship_trackRemarks" value="" disabled>
                                                                </div>
                                                            </div><!--end col-->

                                                        </div>
                                                        <input type="text" id="order_id" name="order_id" value="" style="display: none">


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


                    </div>

                </div>

                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                       data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                        Close</a>
                    @if(Route::currentRouteName() != 'transaction.index')
                    <a href='#' id="button-print-certificate-pdf" class="btn btn-outline-secondary float-end" target="_blank">Print Certificate</a>
                    @endif
                    {{-- <button type="button" class="btn btn-outline-success float-end btn-approve-processing">Continue</button> --}}
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

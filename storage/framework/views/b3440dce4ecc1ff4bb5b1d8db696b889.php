<?php $__env->startSection('title'); ?>
    POS Management
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    

    <link href="<?php echo e(URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css')); ?>"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css')); ?>"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css')); ?>"/> <!-- 'nano' theme -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            POS Management
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Processing
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>




    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-1">
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">Date Range</label>
                                    <input class="form-control" id="basicDate" type="text" placeholder="" data-flatpickr>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                <button id="button-export-pos-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT POS XLSX</button>
                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>
                            <div class="float-end my-3">
                                <button type="button" class="btn btn-soft-success waves-effect float-end ">PRINT CERTIFICATE</button>
                            </div>

                            <div class="py-4">

                                <table id="dt-pos" class="table w-100 table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col"></th>
                                        <th scope="col">TRANSACTION DATE</th>
                                        <th scope="col">TRANSACTION ID</th>
                                        <th scope="col">DETAILS</th>
                                        <th scope="col">DATE PRINTED</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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

    
    <div class="modal fade modalUpdatePos" tabindex="-1" role="dialog"
         aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
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
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your name" id="name" value="ALI BIN ABU">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label for="icNumber" class="form-label">Identification Card Number</label>
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your identification card number" id="icNumber" value="900101121357">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Phone Number</label>
                                                                    <div class="input-group" data-input-flag>
                                                                        <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                                src="<?php echo e(URL::asset('build/images/flags/my.svg')); ?>"
                                                                                alt="flag img" height="20"
                                                                                class="country-flagimg rounded"><span
                                                                                class="ms-2 country-codeno">+60</span></button>
                                                                        <input disabled type="text" class="form-control rounded-end flag-input" value="1634523433" placeholder="Enter your phone number"
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
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your email" id="email" value="aliabu@gmail.com">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">

                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="address" class="form-label">Address</label>
                                                                        <input disabled value="LORONG TAMAN SAUJANA" type="text" class="form-control" placeholder="Enter your address" id="address">
                                                                    </div>
                                                                </div><!--end col-->

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="postcode" class="form-label">Postcode</label>
                                                                        <input disabled value="62832" type="text" class="form-control" placeholder="Enter your postcode" id="postcode">
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">City</label>
                                                                        <input disabled value="KUALA LUMPUR" type="text" class="form-control" placeholder="Enter your city" id="city">
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="state" class="form-label">State</label>
                                                                        <select disabled class="form-select mb-3" aria-label="Default select example">
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
                                                                            <option selected value="14">WILAYAH PERSEKUTUAN KUALA LUMPUR</option>
                                                                            <option value="15">WILAYAH PERSEKUTUAN LABUAN</option>
                                                                            <option value="16">WILAYAH PERSEKUTUAN PUTRAJAYA</option>
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->

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

                            <div class="row">
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
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your name" id="name" value="ALI BIN ABU">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label for="icNumber" class="form-label">Identification Card Number</label>
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your identification card number" id="icNumber" value="900101121357">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label">Phone Number</label>
                                                                    <div class="input-group" data-input-flag>
                                                                        <button disabled class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                                src="<?php echo e(URL::asset('build/images/flags/my.svg')); ?>"
                                                                                alt="flag img" height="20"
                                                                                class="country-flagimg rounded"><span
                                                                                class="ms-2 country-codeno">+60</span></button>
                                                                        <input disabled type="text" class="form-control rounded-end flag-input" value="1634523433" placeholder="Enter your phone number"
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
                                                                        <input disabled type="text" class="form-control" placeholder="Enter your email" id="email" value="aliabu@gmail.com">
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->

                                                            <div class="row">

                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="address" class="form-label">Address</label>
                                                                        <input disabled value="LORONG TAMAN SAUJANA" type="text" class="form-control" placeholder="Enter your address" id="address">
                                                                    </div>
                                                                </div><!--end col-->

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="postcode" class="form-label">Postcode</label>
                                                                        <input disabled value="62832" type="text" class="form-control" placeholder="Enter your postcode" id="postcode">
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">City</label>
                                                                        <input disabled value="KUALA LUMPUR" type="text" class="form-control" placeholder="Enter your city" id="city">
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="state" class="form-label">State</label>
                                                                        <select disabled class="form-select mb-3" aria-label="Default select example">
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
                                                                            <option selected value="14">WILAYAH PERSEKUTUAN KUALA LUMPUR</option>
                                                                            <option value="15">WILAYAH PERSEKUTUAN LABUAN</option>
                                                                            <option value="16">WILAYAH PERSEKUTUAN PUTRAJAYA</option>
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">Tracking Number</label>
                                                                        <input value="" type="text" class="form-control" placeholder="Enter tracking number" id="tn">
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <label for="city" class="form-label">Notes</label>
                                                                        <input value="" type="text" class="form-control" placeholder="" id="tn">
                                                                    </div>
                                                                </div><!--end col-->

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


                        </div>

                    </div>

                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                           data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                            Close</a>
                        <button id="button-print-certificate-pdf" type="button" class="btn btn-outline-secondary float-end">Print Certificate</button>
                        <button type="button" class="btn btn-outline-success float-end">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {

            $('#button-export-xlsx').on('click', function (e) {

                e.preventDefault();
                window.location.href = 'pos-processing/export-xlsx';

            })

            $('#button-export-pos-xlsx').on('click', function (e) {

                e.preventDefault();
                window.location.href = 'pos-processing/export-pos-xlsx';

            })

            $('#button-print-certificate-pdf').on('click', function (e) {

                e.preventDefault();
                window.location.href = 'pos-processing/print-certificate-pdf';

            })


            $("#basicDate").flatpickr(
                {
                    mode: "range",
                    dateFormat: "d-m-Y",
                }
            );
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="<?php echo e(URL::asset('build/libs/datatables/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js')); ?>"></script>
    <script src="<?php echo e(asset('build/js/datatables/pos-processing.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master-mpm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/admin/pos/processing/index.blade.php ENDPATH**/ ?>
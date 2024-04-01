<?php $__env->startSection('title'); ?>
    Reporting (Finance - MOD)
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
            Reporting
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Finance - MOD
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">

                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-secondary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">Successful Transaction</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">26</span></h4>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - RM60</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">RM 1,000.00</span></h4>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL PAYMENT - RM20</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">RM 200.00</span></h4>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate bg-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-semibold text-white mb-0">TOTAL COLLECTION</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-2">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                                    <span class="counter-value" data-target="36894">RM 1,200.00</span></h4>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                        </div>

                        <div class="row gy-1">
                            <div class="col-lg-3">
                                <div class="mt-3">
                                    <label class="form-label mb-3">Date Range</label>
                                    <input class="form-control" id="basicDate" type="text" placeholder="" data-flatpickr>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="mt-3">
                                <!-- Soft Buttons -->
                                <button type="button" class="btn btn-soft-primary waves-effect waves-light material-shadow-none">Search</button>
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
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end">EXPORT PDF</button>
                                <button type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>

                            <div class="py-4">
                                
                                <!-- Striped Rows -->

                                <table id="dt-pos" class="table w-100 table-striped text-center">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">TRANSACTION ID</th>
                                        <th scope="col">RECEIPT NO.</th>
                                        <th scope="col">TRANSACTION DATE</th>
                                        <th scope="col">CANDIDATE NAME</th>
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">RECEIPT</th>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        $(document).ready(function () {
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
    <script src="<?php echo e(asset('build/js/datatables/report-finance.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master-mpm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/admin/report/financial/mod/index.blade.php ENDPATH**/ ?>
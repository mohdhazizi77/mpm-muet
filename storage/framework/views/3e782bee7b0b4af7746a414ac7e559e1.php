<?php $__env->startSection('title'); ?>
    MUET Online Certificate
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 <?php echo e($status == 'SUCCESS' ? 'bg-success-subtle' : 'bg-danger'); ?>  mx-n4 mt-n4 border-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="py-3">
                                    <h3 class="fw-bold">PAYMENT <?php echo e($status); ?>!</h3>
                                    <table class="table-borderless fs-16 mt-3">
                                        <tr>
                                            <td class="fw-bold">
                                                TRANSACTION REFERENCE : <?php echo e($txn_id); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Your MUET certificate will be processed and sent according to the address given.</td>
                                        </tr>
                                        <tr>
                                            <td>An automated payment receipt will be sent to your email.</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
            </div>

            <div class="row py-4">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-12 align-self-center">
                                    <div class="py-4">
                                        
                                        <!-- Striped Rows -->
                                        <table class="table table-striped text-center">
                                            <thead>
                                            <tr class="text-center bg-dark-subtle">
                                                <th scope="col">NO.</th>
                                                <th scope="col">DATE AND TIME</th>
                                                <th scope="col">DESCRIPTION</th>
                                                <th scope="col">STATUS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="align-middle">
                                                <th scope="row">1</th>
                                                <td>09/12/2023 12:30:00</td>
                                                <td></td>
                                                <td><h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        
                                        <div id="modalVerifyPDF" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 overflow-hidden">
                                                    <div class="modal-header p-3 bg-dark-subtle">
                                                        <h4 class="card-title mb-0">Index Number Verification</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-5">
                                                                <label for="indexNumber" class="form-label">Index Number</label>
                                                                <input type="text" class="form-control mb-2" id="indexNumber">
                                                                <a class="text-decoration-none text-black-50" href="#">Forgot Index Number?</a>
                                                            </div>
                                                            <div class="clearfix">
                                                                <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                                <a href="<?php echo e(Route('candidates.printpdf')); ?>" class="btn btn-soft-success waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        
                                        <div id="modalVerifyMPM" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 overflow-hidden">
                                                    <div class="modal-header p-3 bg-dark-subtle">
                                                        <h4 class="card-title mb-0">Index Number Verification</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-5">
                                                                <label for="indexNumber" class="form-label">Index Number</label>
                                                                <input type="text" class="form-control mb-2" id="indexNumber">
                                                                <a class="text-decoration-none text-black-50" href="#">Forgot Index Number?</a>
                                                            </div>
                                                            <div class="clearfix">
                                                                <button type="button" class="btn btn-soft-dark waves-effect waves-light" data-bs-dismiss="modal">Cancel</button>
                                                                <a href="<?php echo e(Route('candidates.printmpm')); ?>" class="btn btn-success btn-animation waves-effect waves-light w-md float-end" data-text="Verify"><span>Verify</span></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        
                                        <div id="modalPayment" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 overflow-hidden">
                                                    <div class="modal-header p-3 bg-dark-subtle">
                                                        <h4 class="card-title mb-0">Payment</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label class="form-label">Candidate must pay RM20 to print MUET certificate</label>
                                                            </div>
                                                            <div class="text-end">
                                                                <a href="#" class="btn btn-success btn-animation waves-effect waves-light" data-text="Continue"><span>Continue</span></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

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

                <?php if (isset($component)) { $__componentOriginalab7c7e4e3c24682594de202551308cc7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7c7e4e3c24682594de202551308cc7 = $attributes; } ?>
<?php $component = App\View\Components\Button\Back::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button.back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Button\Back::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7c7e4e3c24682594de202551308cc7)): ?>
<?php $attributes = $__attributesOriginalab7c7e4e3c24682594de202551308cc7; ?>
<?php unset($__attributesOriginalab7c7e4e3c24682594de202551308cc7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7c7e4e3c24682594de202551308cc7)): ?>
<?php $component = $__componentOriginalab7c7e4e3c24682594de202551308cc7; ?>
<?php unset($__componentOriginalab7c7e4e3c24682594de202551308cc7); ?>
<?php endif; ?>
                
                
                
            </div>


        </div>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('script'); ?>

            <script>

                $(document).ready(function () {

                    $('#button-download').on('click', function (e) {

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-candidate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/candidates/print-mpm-return.blade.php ENDPATH**/ ?>
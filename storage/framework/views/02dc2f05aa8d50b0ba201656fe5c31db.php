<?php $__env->startSection('title'); ?>
    MUET Online Certificate
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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

        <div>

            <?php if (isset($component)) { $__componentOriginalab7c7e4e3c24682594de202551308cc7 = $component; } ?>
<?php $component = App\View\Components\Button\Back::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button.back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Button\Back::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7c7e4e3c24682594de202551308cc7)): ?>
<?php $component = $__componentOriginalab7c7e4e3c24682594de202551308cc7; ?>
<?php unset($__componentOriginalab7c7e4e3c24682594de202551308cc7); ?>
<?php endif; ?>
            <a id="button-download" href="<?php echo e(route('candidates.downloadpdf')); ?>" class="btn btn-soft-success btn-label btn-border waves-effect waves-light w-lg float-end">
                <i class="ri-file-download-line label-icon align-middle fs-16 me-2"></i>DOWNLOAD
            </a>
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

<?php echo $__env->make('layouts.master-candidate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/candidates/print-pdf.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?>
    MUET Online Certificate
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container" style="width: 70%; margin: auto">
        <div class="row pt-5">
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script>

        function populatePassword() {
            var mykad = document.getElementById("username");
            var password = document.getElementById("password");

            password.value = mykad.value;
        }

    </script>

    <script src="<?php echo e(URL::asset('build/libs/particles.js/particles.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/particles.app.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/password-addon.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/candidates/qr-scan.blade.php ENDPATH**/ ?>
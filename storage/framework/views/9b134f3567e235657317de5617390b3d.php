<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Error_404'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->


            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center pt-4">
                                <div class="">
                                    <img src="<?php echo e(URL::asset('build/images/error.svg')); ?>" alt="" height="350" class="error-basic-img move-animation">
                                </div>
                                <div class="mt-n4">
                                    <h1 class="display-1 fw-medium">403</h1>
                                    <h3 class="text-uppercase">Harap Maaf!</h3>
                                    <p class="text-muted mb-4">Anda tidak mempunyai kebenaran untuk melihat sumber atau halaman ini menggunakan akaun anda.</p>
                                    <a href="/candidate/login" class="btn btn-success"></i>Log Masuk</a>
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

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- particles js -->
        <script src="<?php echo e(URL::asset('build/libs/particles.js/particles.js.min.js')); ?>"></script>
        <!-- particles app js -->
        <script src="<?php echo e(URL::asset('build/js/pages/particles.app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/errors/403.blade.php ENDPATH**/ ?>
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
            Administration
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Users
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-12 align-self-center">
                            <div class="float-start my-3">
                                
                            </div>
                            <div class="float-end my-3">
                                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-soft-success waves-effect float-end">NEW USER</a>
                            </div>

                            <div class="py-4">

                                <table id="dt-pos" class="table w-100 table-striped text-center align-middle">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">NO.</th>
                                        <th scope="col">ROLE</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">EMAIL</th>
                                        <th scope="col">PHONE NUMBER</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>ADMINISTRATOR</td>
                                        <td>MOHD HAZIZI</td>
                                        <td>admin@gmail.com</td>
                                        <td>01122223333</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-edit-line label-icon align-middle fs-16 me-2"></i>
                                                EDIT
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>PSM</td>
                                        <td>PSM_ADMIN</td>
                                        <td>adminpsm@gmail.com</td>
                                        <td>0126742643</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-edit-line label-icon align-middle fs-16 me-2"></i>
                                                EDIT
                                            </button>
                                            <button type="button" class="btn btn-soft-danger waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">
                                                <i class="ri-delete-bin-2-line label-icon align-middle fs-16 me-2"></i>
                                                DELETE
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>BPKOM</td>
                                        <td>BPKOM_ADMIN</td>
                                        <td>adminbpkom@gmail.com</td>
                                        <td>0126742643</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-edit-line label-icon align-middle fs-16 me-2"></i>
                                                EDIT
                                            </button>
                                            <button type="button" class="btn btn-soft-danger waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">
                                                <i class="ri-delete-bin-2-line label-icon align-middle fs-16 me-2"></i>
                                                DELETE
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>KEWANGAN</td>
                                        <td>KEWANGAN_ADMIN</td>
                                        <td>adminkewangan@gmail.com</td>
                                        <td>0175236443</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyPDF">
                                                <i class="ri-edit-line label-icon align-middle fs-16 me-2"></i>
                                                EDIT
                                            </button>
                                            <button type="button" class="btn btn-soft-danger waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#modalVerifyMPM">
                                                <i class="ri-delete-bin-2-line label-icon align-middle fs-16 me-2"></i>
                                                DELETE
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

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

                    $('#button-export-xlsx').on('click', function (e) {

                        e.preventDefault();
                        window.location.href = 'pos-new/export-xlsx';

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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master-mpm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/admin/administration/users/index.blade.php ENDPATH**/ ?>
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
                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>
                            </div>

                            <div class="py-4">

                                <table id="dt-pos" class="table w-100 table-striped text-center align-middle">
                                    <thead>
                                    <tr class="text-center bg-dark-subtle">
                                        <th scope="col">NO.</th>
                                        <th scope="col">ACTION BY</th>
                                        <th scope="col">ACTIVITY</th>
                                        <th scope="col">TABLE / ID / DATA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            ADMINISTRATOR
                                            <p>ID: 1</p>
                                        </td>
                                        <td>Create
                                            <p>19/01/2024 11:38</p>
                                        </td>
                                        <td class="text-start">
                                            App\Models\Users ID: 2
                                            <p class="pt-3 fw-bold">Old</p>
                                            <ul>
                                                <li>name:</li>
                                                <li>email:</li>
                                                <li>phone_number:</li>
                                            </ul>
                                            <p class="pt-3 fw-bold">New</p>
                                            <ul>
                                                <li>name: PSM_ADMIN</li>
                                                <li>email: adminpsm@gmail.com</li>
                                                <li>phone_number: 01125235367</li>
                                            </ul>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>
                                            ADMINISTRATOR
                                            <p>ID: 1</p>
                                        </td>
                                        <td>Update
                                            <p>20/01/2024 11:38</p>
                                        </td>
                                        <td class="text-start">
                                            App\Models\Users ID: 2
                                            <p class="pt-3 fw-bold">Old</p>
                                            <ul>
                                                <li>status: NEW</li>
                                                <li>updated_at:</li>
                                            </ul>
                                            <p class="pt-3 fw-bold">New</p>
                                            <ul>
                                                <li>status: PROCESSING</li>
                                                <li>updated_at: 2023-11-01 10:33:47</li>
                                            </ul>
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


<?php echo $__env->make('layouts.master-mpm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/admin/administration/audit-logs/index.blade.php ENDPATH**/ ?>
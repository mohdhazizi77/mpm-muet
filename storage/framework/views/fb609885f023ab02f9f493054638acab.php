<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/mpm-logo.png')); ?>" alt="" height="38">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/mpm-logo.png')); ?>" alt="" height="38">
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/mpm-logo.png')); ?>" alt="" height="38">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/mpm-logo.png')); ?>" alt="" height="38">
                        </span>
                    </a>
                </div>

                
                
                
                
                
                
                

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-sm-3 header-item ">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset('build/images/users/user-dummy-img.jpg')); ?><?php else: ?><?php echo e(URL::asset('build/images/users/user-dummy-img.jpg')); ?><?php endif; ?>"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text"><?php echo e(strtoupper(Auth::user()->name)); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-13 user-name-sub-text">ADMIN</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="pages-profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item " href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                        <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php /**PATH C:\Users\hazizi-3TDS\Desktop\CODE\mpm-muet\resources\views/layouts/topbar-mpm.blade.php ENDPATH**/ ?>
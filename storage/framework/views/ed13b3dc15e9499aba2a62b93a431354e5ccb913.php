<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal " href="/dashboard">
                <img src="<?php echo e(asset(env('APP_LOGO'))); ?>" class="header-brand-img desktop-logo" alt="logo1h">
                <img src="<?php echo e(asset(env('APP_LOGO'))); ?>" class="header-brand-img light-logo1" alt="logo2h" style="height:auto !important; width:100px !important;">
            </a>
            <!-- LOGO -->

            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <div class="dropdown d-none">
                    <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                        <i class="fe fe-search"></i>
                    </a>
                    <div class="dropdown-menu header-search dropdown-menu-start">
                        <div class="input-group w-100 p-2">
                            <input type="text" class="form-control" placeholder="Search....">
                            <div class="input-group-text btn btn-primary">
                                <i class="fe fe-search" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">
                            <div class="dropdown d-lg-none d-flex">
                                <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu header-search dropdown-menu-start">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control" placeholder="Search....">
                                        <div class="input-group-text btn btn-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- COUNTRY -->
                            <!-- <div class="d-flex country">
                                <a class="nav-link icon text-center" data-bs-target="#country-selector"
                                    data-bs-toggle="modal">
                                    <i class="fe fe-globe"></i><span class="fs-16 ms-2 d-none d-xl-block">English</span>
                                </a>
                            </div> -->
                            <!-- SEARCH -->
                            <div class="dropdown  d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <!-- Theme-Layout -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
                            <!-- FULL-SCREEN -->

                            <!-- SIDE-MENU -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">

                                    <?php if(isset(Auth::user()->image) && Auth::user()->image != NULL): ?>

                                    <img src="<?php echo e(asset('/uploads/files/'.Auth::user()->image)); ?>" alt="profile-user" class="avatar  profile-user brround cover-image">
                                    <?php else: ?>
                                    <img src="<?php echo e(asset('assets/images/users/21.jpg')); ?>" alt="profile-user" class="avatar  profile-user brround cover-image">
                                    <?php endif; ?>


                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
<div class="drop-heading">
                                        <?php if(Auth::user()->hasRole('Tenant')): ?>
                                        <div class="text-start">
                                            <h5 class="text-dark mb-0 fs-14 fw-semibold"><?php echo e(ucwords(Auth::user()->buisness_name)); ?></h5>
                                        </div>
                                        <?php else: ?>
                                        <div class="text-start">
                                            <h5 class="text-dark mb-0 fs-14 fw-semibold"><?php echo e(ucwords(Auth::user()->first_name)); ?> <?php echo e(Auth::user()->last_name); ?></h5>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item" href="<?php echo e(url('/profile')); ?>">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>

                                    <form method="post" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="dropdown-item" type="submit">
                                            <i class="side-menu__icon fe fe-log-out"></i>
                                            <span class="side-menu__label text-dark"><?php echo e(__('Log out')); ?></span>

                                        </button>
                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Taimoor Ahmad\Desktop\taimoor's work\streaming\resources\views/includes/header.blade.php ENDPATH**/ ?>
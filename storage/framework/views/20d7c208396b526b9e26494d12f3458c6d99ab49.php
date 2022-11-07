<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Dealer Reg – Dealer Reg">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(env('APP_ICON'))); ?>" />



    <!-- TITLE -->
    <title><?php echo $__env->yieldContent('title'); ?> – <?php echo e(env('APP_NAME')); ?> </title>

    <?php echo $__env->make('includes.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
        @media (max-width: 415px) and (height: 1368px) {
            .profileImg {
                width: 72px !important;
                height: 39px !important;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
                // var window_width = $(window).width();
                // if ($(window).width() < 800) {

                //     $(".app .app-sidebar").css('left','-270px');
                //     $(".app .app-sidebar").css('top','73px');
                // } else {

                //     //$('.app-sidebar__toggle').css('opacity','0');
                //     $('.app-sidebar__toggle').click();
                // }
                
                const mq = window.matchMedia( "(min-width: 960px)" );

                if (mq.matches) {
                    $('.app-sidebar__toggle').click();
                } else {
                    $(".app .app-sidebar").addClass('sidenav-toggled');
                    // $(".app .app-sidebar").css('width','80px');
                    // $(".app .app-sidebar").css('overflow','hidden');
                }

        })
    </script>



</head>

<body class="app sidebar-mini ltr light-mode">

    <!-- GLOBAL-LOADER -->
    <!--<div id="global-loader">-->
    <!--    <img src="<?php echo e(asset('assets/images/loader.svg')); ?>" class="loader-img" alt="Loader">-->
    <!--</div>-->
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->
            <?php echo $__env->make('includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <?php echo $__env->yieldContent('content'); ?>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->

        </div>




        <!-- FOOTER -->
        <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- FOOTER END -->

    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <?php echo $__env->make('includes.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH C:\Users\Taimoor Ahmad\Desktop\taimoor's work\streaming\resources\views/layouts/master.blade.php ENDPATH**/ ?>
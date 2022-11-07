<?php $__env->startSection('title'); ?>
    Scan Qrcode
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- CONTAINER -->
    <div class="container-fluid" >

        <div class="row  d-flex justify-space-between">
            <div class="col-6">
                <h5>Live Streaming</h5>
            </div>



        </div>
        <div class="mt-3" id="app">
            <?php if($type === 'broadcaster'): ?>

                <broadcaster :auth_user_id="<?php echo e($id); ?>" env="<?php echo e(env('APP_ENV')); ?>"
                             turn_url="<?php echo e(env('TURN_SERVER_URL')); ?>" turn_username="<?php echo e(env('TURN_SERVER_USERNAME')); ?>"
                             turn_credential="<?php echo e(env('TURN_SERVER_CREDENTIAL')); ?>"/>

            <?php else: ?>
                <viewer stream_id="<?php echo e($streamId); ?>" :auth_user_id="<?php echo e($id); ?>"
                        turn_url="<?php echo e(env('TURN_SERVER_URL')); ?>" turn_username="<?php echo e(env('TURN_SERVER_USERNAME')); ?>"
                        turn_credential="<?php echo e(env('TURN_SERVER_CREDENTIAL')); ?>"/>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-script'); ?>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-streaming', function (e) {
                alert('Streaming feature will be implemented here')
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.min', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Taimoor Ahmad\Desktop\taimoor's work\streaming\resources\views/templates/external/live_streaming.blade.php ENDPATH**/ ?>
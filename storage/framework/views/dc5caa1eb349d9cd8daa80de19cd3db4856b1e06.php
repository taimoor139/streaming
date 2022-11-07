<?php $__env->startSection('title'); ?>
Scan Qrcode
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- CONTAINER -->
<div class="container-fluid">

    <div class="row  d-flex justify-space-between">
        <div class="col-6">
            <h5>Live Streaming</h5>
        </div>
        <a href="javascript:;" class="btn btn-primary btn-streaming" streaming-link="rtsp://admin:troiano10!@68.195.234.210:3067/chID=4&streamType=main&linkType=tcp">Click to start streaming</a>
    </div>
    <div class="mt-3">
        <h4><strong>Instructions</strong></h4>
        <ol>
            <li>There will be multiple / dynamic live streaming links</li>
            <li>We need a way, where user will select the camera & then streaming will start for that cameram </li>
        </ol>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-script'); ?>
<script>
    $(document).ready(function(){
        $(document).on('click','.btn-streaming',function(e){
            alert('Streaming feature will be implemented here')
        })
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.min', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lok3rn5/fastlobby.com/resources/views/templates/external/live_streaming.blade.php ENDPATH**/ ?>
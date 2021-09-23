

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <!-- Meeting minutes -->
      <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route("meetings.show",$meeting->id)); ?>" style="color:black;text-decoration:none">
        <div class="card"">
          <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
          <div class="card-body">
            <h5><?php echo e($meeting->title); ?></h5>
            <div><?php echo e($meeting->date); ?></div>
            <div><?php echo e($meeting->time); ?></div>
            <div><?php echo e($meeting->venue); ?></div>
          </div>

        </div>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/view.blade.php ENDPATH**/ ?>
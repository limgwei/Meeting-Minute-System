

<?php $__env->startSection('content'); ?>

<!-- <style>
  .printme{
    displa
  }
</style> -->

<div id="printThis" class="printme">

  <div>
    <h1>Meeting:<?php echo e($meeting->title); ?></h1>
    <p>Date:<?php echo e($meeting->date); ?></p>
    <p>Time:<?php echo e($meeting->time); ?></p>
    <p>Venue:<?php echo e($meeting->venue); ?></p>



  </div>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/meeting/exportPDF.blade.php ENDPATH**/ ?>
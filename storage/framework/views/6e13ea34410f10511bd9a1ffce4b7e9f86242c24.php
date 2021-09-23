

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

      <a href="<?php echo e(route("pending_agendas.add",$group_id)); ?>" class="btn btn-success">Add Agenda</a>
      <a href="<?php echo e(route("meetings.create",$group_id)); ?>" class="btn btn-success">Create Meeting</a>
      <!-- Meeting minutes -->
      <?php $__currentLoopData = $pending_agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pending_agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card" style="border:1px solid black;">
        <div class="card-body">
          <div class="">
            <button class="btn btn-primary"><?php echo e($pending_agenda->title); ?> (<?php echo e($pending_agenda->users->name); ?>) </button>
            <div>
              <div>
                Description:<?php echo e($pending_agenda->description); ?>

              </div>
              <div>
                Attachment File
                <a href="<?php echo e(asset('/storage/'.$pending_agenda->file)); ?>" download><?php echo e($pending_agenda->filename); ?></a>
              </div>
              <?php if($pending_agenda->editable): ?>
              <a href="<?php echo e(route('pending_agendas.view',$pending_agenda->id)); ?>" class="btn btn-primary">Edit</a>
              <?php endif; ?>
              <a href="" class="btn btn-success">View</a>
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      </div>
    </div>
  </div>


  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/pending_agenda/index.blade.php ENDPATH**/ ?>
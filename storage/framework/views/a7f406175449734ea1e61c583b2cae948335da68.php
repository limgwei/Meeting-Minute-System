

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column" style="gap:10px">
  <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="padding-5 d-flex flex-column">
    <div class="d-flex justify-content-between">
      <div class="inter-bold header_text"><?php echo e(__('pending_agenda.pending_agenda')); ?></div>
      <div class="d-flex ">
        <?php if($create_meeting): ?>
        <a href="<?php echo e(route("meetings.create",$group_id)); ?>" class="btn btn-default button_text"><?php echo e(__('pending_agenda.create_meeting')); ?></a>
        <?php endif; ?>
        <a href="<?php echo e(route("pending_agendas.add",$group_id)); ?>" class="btn btn-primary button_text"><?php echo e(__('pending_agenda.add_agenda')); ?></a>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:275px;grid-gap:50px">
      <?php $__currentLoopData = $pending_agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pending_agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column justify-content-between">
          <div class="d-flex flex-column" style="gap:10px">
            <div class="d-flex" style="gap:30px">
              <div> <?php if($pending_agenda->users->file): ?>
                <img src="<?php echo e(asset('/storage/'.$pending_agenda->users->file)); ?>" class="img-card" alt="Card image cap" style="width:50px;height:50px">
                <?php else: ?>
                <img class="img-card" src="<?php echo e(asset('/storage/icon/user.png')); ?>" alt="Card image cap" style="width:50px;height:50px">
                <?php endif; ?>
              </div>
              <div class="d-flex flex-column">
                <div class="inter-bold"><?php echo e($pending_agenda->users->name); ?></div>
                <div class="inter-regular plain_text"><?php echo e($pending_agenda->position); ?></div>
              </div>

            </div>
            <div class="d-flex flex-column" style="gap:10px">
              <div class="plain_text">TITLE: <span class="inter-bold"><?php echo e($pending_agenda->title); ?></span> </div>
              <div class="plain_text"><?php echo e($pending_agenda->description); ?> </div>
              <div class="plain_text"><?php echo e(__('pending_agenda.file')); ?>: <span class="inter-bold"><a href="<?php echo e(asset('/storage/'.$pending_agenda->file)); ?>" download><?php echo e($pending_agenda->filename); ?></a></span> </div>

            </div>
          </div>

          <?php if($pending_agenda->editable): ?>
          <a style="color:white;" href="<?php echo e(route('pending_agendas.view',$pending_agenda->id)); ?>">
          <div class="btn btn-primary button_text d-flex justify-content-center">
            EDIT
          </div>
          </a>
          <?php endif; ?>

        </div>
      </div>
      
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/pending_agenda/index.blade.php ENDPATH**/ ?>
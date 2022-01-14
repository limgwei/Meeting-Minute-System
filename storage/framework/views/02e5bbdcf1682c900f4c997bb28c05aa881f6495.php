

<div class="navbar navbar-expand-lg navbar-ligh d-flex justify-content-around" style="border:1px solid #e8e8e8;background:white" >
  <a class="navbar-brand inter-regular" href="<?php echo e(route("groups.show",$group_id)); ?>" style="color:<?php echo e(Route::is('groups.show')?'#007bff':'black'); ?>"><?php echo e(__('layout.schedule')); ?></a>
  <a class="navbar-brand inter-regular" href="<?php echo e(route("pending_agendas.index",$group_id)); ?>" style="color:<?php echo e(Route::is('pending_agendas.index')?'#007bff':'black'); ?>"><?php echo e(__('layout.pending_agenda')); ?></a>
  <a class="navbar-brand inter-regular" href="<?php echo e(route("groups.members",$group_id)); ?>" style="color:<?php echo e(Route::is('groups.members')?'#007bff':'black'); ?>"><?php echo e(__('layout.member')); ?></a>
</div><?php /**PATH C:\xampp\htdocs\minut\resources\views/layouts/meetingNav.blade.php ENDPATH**/ ?>
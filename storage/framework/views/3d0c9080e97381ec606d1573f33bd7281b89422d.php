

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo e(route("groups.show",$group_id)); ?>" style="color:<?php echo e(Route::is('groups.show')?'blue':'black'); ?>">Current Schedule</a>
  <a class="navbar-brand" href="<?php echo e(route("pending_agendas.index",$group_id)); ?>" style="color:<?php echo e(Route::is('pending_agendas.index')?'blue':'black'); ?>">Pending Agenda</a>
  <a class="navbar-brand" href="#" >Member</a>
</nav><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/layouts/meetingNav.blade.php ENDPATH**/ ?>
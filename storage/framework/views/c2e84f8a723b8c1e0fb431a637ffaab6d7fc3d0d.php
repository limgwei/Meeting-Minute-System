

<?php $__env->startSection('content'); ?>
<div class="padding-5">

  <h5 class="inter-bold header_text">
    <?php echo e(__('setting.notification')); ?>

  </h5>

  <div class="card border_radius_12" style="margin:24px 0 0 0">
    <div class="card-body">
      <div>

        <?php $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invitation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($invitation->is_approve!=0): ?>

        <div class="card border_radius_12 padding-5 <?php echo e($invitation->is_seen==1?'bg-light':''); ?> border_radius_12">
          <div class="inter-medium"><span class="inter-bold"><?php echo e($invitation->receiver->name); ?></span> has <?php echo e($invitation->is_approve==1?'accepted':'rejected'); ?> your invitation to <span class="inter-bold"><?php echo e($invitation->group->title); ?></span></div>
        </div>
        <?php else: ?>
        <div class="card border_radius_12 padding-5 <?php echo e($invitation->is_seen==1?'bg-light':''); ?>">
          <div class="inter-medium"><span class="inter-bold"><?php echo e($invitation->sender->name); ?></span> has invited you to join <span class="inter-bold"><?php echo e($invitation->group->title); ?></span> </div>
          <div class="d-flex justify-content-end" style="gap:10px">
            <a href="<?php echo e(route('invitation.reply',[$invitation->id,1])); ?>" class="btn btn-success">Accept</a>
            <a href="<?php echo e(route('invitation.reply',[$invitation->id,2])); ?>" class="btn btn-danger">Reject</a>
          </div>
        </div>
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      </div>
    </div>
  </div>

</div>

<script>
  $("#notification").remove();
  var url = '/<?php echo e(env("base_url")); ?>' + 'notification/update';
  $.ajax({
    type: "GET",
    url: url,
    success: function(data) {

    },
    erros: function(data) {
      console.log(data);
    }
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/settings/invitation.blade.php ENDPATH**/ ?>
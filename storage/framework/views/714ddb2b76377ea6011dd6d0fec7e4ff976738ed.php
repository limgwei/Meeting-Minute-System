

<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('js/change_group.js')); ?>"></script>
<div class="padding-5 d-flex flex-column" style="gap:20px">
  <div class="inter-bold header_text">
    <a href="<?php echo e(route("pending_agendas.index",$group_id)); ?>"><i class="bi bi-arrow-left-circle" style="font-size:24px"></i> </a><?php echo e(__('pending_agenda.add_agenda')); ?>

  </div>
  <div class="card border_radius_12">
    <form class="card-body" enctype="multipart/form-data" action="<?php echo e(route('pending_agendas.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="group_id" value="<?php echo e($group_id); ?>">

      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('pending_agenda.title')); ?><span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required maxlength="20">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('pending_agenda.description')); ?></div>
          <input type="text" class="form-control input_text" name="description" required >
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('pending_agenda.file')); ?><span class="text-danger">*</span></div>
          <input value="" type="file" class="form-control form-control-lg" name="file" accept=".pdf" maxlength="20">
        </div>

        <div class="d-flex flex-row-reverse " >
          <button type="submit" class="btn btn-primary button_text">
            <?php echo e(__('pending_agenda.create_agenda')); ?></i>
          </button>
        </div>

      </div>

    </form>
  </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/pending_agenda/add.blade.php ENDPATH**/ ?>
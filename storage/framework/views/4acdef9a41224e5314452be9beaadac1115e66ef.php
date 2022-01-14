

<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('js/change_group.js')); ?>"></script>
<div class="container">
  <div class="row justify-content-center">
    <div class="d-flex flex-column" style="width:100%">
      <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
          <div class="page-title d-flex">
            <h4>
              <span class="font-weight-bold mr-2">Editing</span>
              <i class="icon-circle-right2 mr-2"></i>
              <span class="font-weight-bold mr-2">Position</span>
            </h4>
          </div>
        </div>
      </div>

      <div class="content">
        <div>
          <div class="card">
            <div class="card-body">
              <form enctype="multipart/form-data" action="<?php echo e(route('groupsMember.updatePosition')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" value="<?php echo e($member_group->id); ?>" name="id">
                <input type="hidden" value="<?php echo e($member_group->group_id); ?>" name="group_id">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-address-book mr-2"></i>
                </legend>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Position:</label>
                  <div class="col-lg-9">
                    <input value="<?php echo e($member_group->position); ?>" type="text" class="form-control form-control-lg" name="position" placeholder="Position" required>
                  </div>
                </div>
                </div>
                
                <div class="text-right" style="float:right">
                  <button type="submit" class="btn btn-primary">
                    UPDATE
                    <i class="icon-database-insert ml-1"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/editPosition.blade.php ENDPATH**/ ?>
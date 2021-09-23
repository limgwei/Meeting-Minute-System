

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
              <span class="font-weight-bold mr-2">Group</span>
            </h4>
          </div>
        </div>
      </div>

      <div class="content">
        <div>
          <div class="card">
            <div class="card-body">
              <form enctype="multipart/form-data" action="<?php echo e(route('pending_agendas.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="group_id" value="<?php echo e($group_id); ?>">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-address-book mr-2"></i>
                </legend>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Title:</label>
                  <div class="col-lg-9">
                    <input value="" type="text" class="form-control form-control-lg" name="title" placeholder="Title" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Description:</label>
                  <div class="col-lg-9">
                    <input value="" type="text" class="form-control form-control-lg" name="description" placeholder="Description" >
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Attachment File:</label>
                  <div class="col-lg-9">
                    <input value="" type="file" class="form-control form-control-lg" name="file">
                  </div>
                </div>
                
                <div class="text-right" style="float:right">
                  <button type="submit" class="btn btn-success">
                    Add
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/pending_agenda/add.blade.php ENDPATH**/ ?>
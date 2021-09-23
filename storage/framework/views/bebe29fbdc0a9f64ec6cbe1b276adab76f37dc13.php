

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
              <form enctype="multipart/form-data" action="<?php echo e(route('groups.update',$group->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-address-book mr-2"></i>
                </legend>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Title:</label>
                  <div class="col-lg-9">
                    <input value="<?php echo e($group->title); ?>" type="text" class="form-control form-control-lg" name="title" placeholder="Title" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Code:</label>
                  <div class="col-lg-9 d-flex">
                    <input value="<?php echo e($group->password); ?>" type="text" class="form-control form-control-lg" disabled id="code">
                    <button type="button" class="btn btn-primary" onclick="change('<?php echo e($group->id); ?>')">
                      Change
                    </button>
                    <div>
                    </div>
                  </div>
                </div>

                <div class="text-left" style="float:left">
                  <a class="btn btn-danger text-white" href="<?php echo e(route('groups.delete',$group->id)); ?>" method="POST">
                    DELETE
                    <i class="icon-trash ml-1"></i>
                  </a>
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

        <div class="table-responsive">
            <table class="table table-striped" id="groupMemberDatabale" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Email</th>
                  <th class="text-center" ><i class="
                                icon-circle-down2"></i></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

      </div>
    </div>
  </div>
</div>

<script>

  
      $('#groupMemberDatabale').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        lengthMenu: [10, 25, 50, 100, 200, 500],
        order: [
          [0, "desc"]
        ],
        ajax: '<?php echo e(route("groupsMember.Datatable",$group->id)); ?>',
        columns: [
          {
            data: 'name'
          },
           {
            data: 'positions'
          },
          {
            data: 'email'
          },
          {
            data: 'action',
            sortable: false,
            searchable: false
          },
        ],
        colReorder: true,
        scrollCollapse: true,
        dom: '<"custom-processing-banner"r>flBtip',
        language: {
          search: '_INPUT_',
          searchPlaceholder: 'Search with anything...',
          lengthMenu: '_MENU_',
          paginate: {
            'first': 'First',
            'last': 'Last',
            'next': '&rarr;',
            'previous': '&larr;'
          },
          processing: '<i class="icon-spinner10 spinner position-left mr-1"></i>Waiting for server response...'
        },
        buttons: []
      });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/edit.blade.php ENDPATH**/ ?>
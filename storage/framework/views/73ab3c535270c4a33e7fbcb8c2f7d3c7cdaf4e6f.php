

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-row justify-content-between" style="width:50%">
  <button type="button" class="btn btn-secondary btn-success" data-toggle="modal" data-target="#addNewGroup"><b><i class="icon-plus2" ></i></b>
    Add New Group
  </button>
  <button type="button" class="btn btn-secondary btn-success" data-toggle="modal" data-target="#joinGroup"><b><i class="icon-plus2" ></i></b>
    Join new group
  </button>
</div>
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="groupDatabale" width="100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Creator</th>
                  <th>Created At</th>
                  <!-- <th class="text-center" style="width: 10%;">Actions</th> -->
                  <th class="text-center" style="width: 20%;"><i class="
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
</div>

<div id="addNewGroup" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Add New Group</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('groups.store')); ?>" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Title:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="title" placeholder="Title" required>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            SAVE
                            <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="joinGroup" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Join Group</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route("groups.joinGroup")); ?>" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Code:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="code" required>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            Join
                            <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
      $('#groupDatabale').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        lengthMenu: [10, 25, 50, 100, 200, 500],
        order: [
          [0, "desc"]
        ],
        ajax: '<?php echo e(route("groupsDatatable")); ?>',
        columns: [{
            data: 'id',
            visible: false,
            searchable: false
          },
          {
            data: 'title'
          },
          {
            data: 'user_id'
          },
          // {
          //     data: 'hex',
          //     render: function(data, type, row) {
          //         return '<input type="color" value="' + data + '" disabled>';
          //     }
          // },
          {
            data: 'created_at'
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
        buttons: {
          dom: {
            button: {
              className: 'btn btn-sm btn-primary ml-1'
            }
          },
          buttons: [{
            extend: 'csv',
            filename: 'store-owners-' + new Date().toISOString().slice(0, 10),
            text: 'Export as CSV'
          }, ]
        }
      });
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/group/index.blade.php ENDPATH**/ ?>
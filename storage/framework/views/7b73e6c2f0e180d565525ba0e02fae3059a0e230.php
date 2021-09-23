

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

      <!-- Group Member -->
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="groupMemberDatabale" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Email</th>
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
<script>

  $('#groupMemberDatabale').DataTable({
    processing: true,
    serverSide: true,
    stateSave: true,
    lengthMenu: [10, 25, 50, 100, 200, 500],
    order: [
      [0, "desc"]
    ],
    ajax: '<?php echo e(route("groupsMember.Datatable",$group_id)); ?>',
    columns: [{
        data: 'name'
      },
      {
        data:'positions'
      },
      {
        data: 'email'
      }
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
      buttons: []
    }
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/member.blade.php ENDPATH**/ ?>
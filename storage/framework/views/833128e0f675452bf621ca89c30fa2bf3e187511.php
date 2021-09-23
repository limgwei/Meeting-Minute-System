

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
      <!-- Meeting minutes -->
      <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route("meetings.show",$meeting->id)); ?>" style="color:black;text-decoration:none">
        <div class="card"">
          <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
          <div class="card-body">
            <h5><?php echo e($meeting->title); ?></h5>
            <div><?php echo e($meeting->date); ?></div>
            <div><?php echo e($meeting->time); ?></div>
            <div><?php echo e($meeting->venue); ?></div>
          </div>

        </div>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


      <!-- Group Member -->
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="groupMemberDatabale" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
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
  function myFunction(number) {

    var currentStatus = $("#dropdown" + number).css("display");

    if (currentStatus == "none") {
      $("#dropdown" + number).css("display", "block");
    } else {
      $("#dropdown" + number).css("display", "none");
    }

  }

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
      buttons: [{
        extend: 'csv',
        filename: 'store-owners-' + new Date().toISOString().slice(0, 10),
        text: 'Export as CSV'
      }, ]
    }
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/group/view.blade.php ENDPATH**/ ?>
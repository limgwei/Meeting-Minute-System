

<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('js/change_group.js')); ?>"></script>
<div class="padding-5">
  <div class="d-flex align-items-center" style="gap:10px">
    <a href="<?php echo e(route('groups.index')); ?>"><i class="bi bi-arrow-left-circle" style="font-size:24px"></i> </a>
    <div class="inter-bold header_text"><?php echo e(__('group.edit_group')); ?></div>
  </div>

  <form class="card border_radius_12" enctype="multipart/form-data" action="<?php echo e(route('groups.update',$group->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-body d-flex flex-column" style="gap:30px">
      <div class="d-flex justify-content-around" style="gap:50px">
        <div class="d-flex flex-column" style="gap:20px;flex-grow:8">

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text"><?php echo e(__('group.title')); ?><span class="text-danger">*</span></div>
            <div class="d-flex" style="gap:20px">
              <input type="text" class="form-control input_text" name="title" value="<?php echo e($group->title); ?>" style="max-width:500px" required>
              <button class="btn btn-primary button_text d-flex align-self-end" style="width:max-content"><?php echo e(__('group.update')); ?></button>
            </div>

          </div>

          <!-- password ,change,delete -->
          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text"><?php echo e(__('group.code')); ?></div>
            <div class="d-flex">
              <input type="text" id="code" class="form-control input_text" name="title" value="<?php echo e($group->password); ?>" style="width:fit-content" disabled>
              <button type="button" class="btn btn-default" style="color:blue" onclick="change('<?php echo e($group->id); ?>')"><?php echo e(__('group.change')); ?></button>

              <a href="<?php echo e(route('groups.delete',$group->id)); ?>" class="btn btn-default" style="color:red"  ><?php echo e(__('group.delete')); ?></a>

            </div>

          </div>



        </div>
        <!-- image -->
        <div style="position:relative;text-align:center;color:white">
          <?php if($group->file): ?>
          <img src="<?php echo e(asset('/storage/'.$group->file)); ?>" alt="Card image cap" id="output" class="hover_button">

          <?php else: ?>
          <img src="<?php echo e(asset('/storage/icon/group.jpg')); ?>" alt="Card image cap" id="output" class="hover_button">
          <?php endif; ?>
          <label for="image" class="picture_hover">
            <div class="d-flex justify-content-center align-items-center ">
              <i class="bi bi-camera" style="font-size:50px"></i>
            </div>
          </label>
          <input type="file" accept="image/*" style="display: none" id="image" onchange="loadFile(event)" name="file">
        </div>
      </div>

      <!-- bottom -->
      <div>
        <table class="table table-striped" style="width:100%" id="groupMemberDatabale">
          <thead>
            <tr>
              <th scope="col"><?php echo e(__('group.name')); ?></th>
              <th scope="col"><?php echo e(__('group.position')); ?></th>
              <th scope="col"><?php echo e(__('group.email')); ?></th>
              <th scope="col" class="text-center"><i class="
                                icon-circle-down2"></i></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

    </div>

  </form>
</div>
<div class="d-flex justify-content-around flex-column">

  <div id="editPosition" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><span class="font-weight-bold header_text"><?php echo e(__('group.edit_position')); ?></span></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="<?php echo e(route('groupsMember.updatePosition')); ?>" method="POST">
            <input type="hidden" name="user_id" value="0" id="user_id">
            <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>" id="group_id">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label plain_text"><span class="text-danger">*</span><?php echo e(__('group.position')); ?>:</label>
              <div class="col-lg-9">
                <input type="text" class="form-control input_text" name="position" placeholder="<?php echo e(__('group.position')); ?>" required id="position">
              </div>
            </div>
            <?php echo csrf_field(); ?>
            <div class="text-right">
              <button type="submit" class="btn btn-primary button_text">
                <?php echo e(__('group.save')); ?>

              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <button style="display:none" data-toggle="modal" data-target="#editPosition" id="editPositionButton"><?php echo e(__('group.add_group')); ?></button>




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
    columns: [{
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
    createdRow: function(row, data, dataIndex, cells) {
      $(row).addClass('plain_text');
    },
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

    },
    buttons: []
  });
</script>

<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>


<script>
  function editPosition(id) {
    $("#editPositionButton").click();
    $("#user_id").val(id);
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/edit.blade.php ENDPATH**/ ?>


<?php $__env->startSection('content'); ?>


<style>
  .dropdown-btn {
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
  }
</style>
<div class="container card" style="padding:5%">
  <div class="row justify-content-center">
    <div style="width:100%">
      <h1>Meeting:<?php echo e($meeting->title); ?></h1>
      <p>Date:<?php echo e($meeting->date); ?></p>
      <p>Time:<?php echo e($meeting->time); ?></p>
      <p>Venue:<?php echo e($meeting->venue); ?></p>
      <p>Organiser:<?php echo e($meeting->organiser->name); ?></p>
      <p>Secretary:<?php echo e($meeting->secretary->name); ?></p>
      <?php if($is_admin): ?>
      <p>Attendance <label><input type="checkbox" id="checkAll"><span>Select all</span></label></p>
      <form action="<?php echo e(route('meetings.checkAttendance')); ?>" method="POST" id="attendanceForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" value="<?php echo e($meeting_id); ?>" name="meeting_id">
        <div class="d-flex flex-column">
          <?php $__currentLoopData = $group_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <label><input type="checkbox" name="attendance[]" value="<?php echo e($group_member->member_id); ?>" <?php echo e($group_member->is_present?'checked':''); ?> class="checkbox"><span><?php echo e($group_member->members->name); ?>,<?php echo e($group_member->position); ?>

            </span></label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="d-flex">
          <button class="btn btn-primary" onclick="submitAttendance()">Save</button>
            <?php endif; ?>
            <?php if($meeting->meeting_file): ?>
            <a href="<?php echo e(route('meetings.exportPDF',$meeting_id)); ?>" target="_blank" class="btn btn-success">Generate PDF</a>
            <?php endif; ?>
          </div>
        </div>
      </form>

    </div>
    <div class="d-flex flex-column" style="width:100%">
      <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <div class="" style="padding:5% 5% 5% 5%;background-color:#f8f9fa;border-radius:12px">
        <h2><?php echo e($title->title); ?></h2>
        <!-- Meeting minutes -->
        <?php $__currentLoopData = $title->agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="card-body">
          <div>
            <button class="dropdown-btn margin-right-5 d-flex justify-content-between" onclick="dropDown(<?php echo e($agenda->id); ?>)" id="dropDown<?php echo e($agenda->id); ?>" style="text-align:left;width:100%"><span><b> <?php echo e($agenda->title); ?></b> (<?php echo e($agenda->users->name); ?>)</span> <span><img src="<?php echo e(asset('/storage/image/dropup.png')); ?>" style="width:16px;height:16px" id="icon<?php echo e($agenda->id); ?>"></span> </button>




            <div id="dropdown<?php echo e($agenda->id); ?>" style="display:none">
              <div>
                <p><?php echo e($agenda->description); ?></p>
              </div>
              <div>
                Attachment File
                <a href="<?php echo e(asset('/storage/'.$agenda->file)); ?>" download><?php echo e($agenda->filename); ?></a>
              </div>
              <div>
                Key points
                <?php if($is_admin): ?>
                <button class="btn btn-success" onclick="addNewKeypoint(<?php echo e($agenda->id); ?>)">Add New</button>
                <?php endif; ?>

                <ul id="keypointOrder<?php echo e($agenda->id); ?>">
                  <?php $__currentLoopData = $agenda->keypoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keypoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($is_admin): ?>
                  <li><input name="keypoint<?php echo e($agenda->id); ?>[]" cols="100" rows="1" class="form-control key" value="<?php echo e($keypoint); ?>" style="border-radius:8px"></li>
                  <br>
                  <?php else: ?>
                  <li><?php echo e($keypoint); ?></li>
                  <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Action taken:</label>
                  <div class="col-lg-12">
                    <?php if($is_admin): ?>
                    <input type="text" name="action_taken" class="form-control" id="action_taken<?php echo e($agenda->id); ?>" value="<?php echo e($agenda->action_taken); ?>">

                    <?php else: ?>
                    <?php if($agenda->action_taken): ?>
                    <div class="form-control"><?php echo e($agenda->action_taken); ?></div>
                    <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Taken by:</label>
                  <?php if($is_admin): ?>
                  <select name="action_user_id" class="form-control form-control-lg" id="taken_by<?php echo e($agenda->id); ?>" style="width:50%">
                    <?php $__currentLoopData = $group_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($group_member->members->id); ?>" <?php echo e($group_member->members->id==$agenda->action_user_id?"selected":""); ?>><?php echo e($group_member->members->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </select>
                  <?php else: ?>
                  <?php if($agenda->action_user): ?>
                  <div class="form-control"><?php echo e($agenda->action_user->name); ?></div>
                  <?php endif; ?>

                  <?php endif; ?>


                </div>
                <?php if($is_admin): ?>

                <button class="btn btn-success" style="" onclick="saveKeypoints(<?php echo e($agenda->id); ?>)">Save</button>

                <?php endif; ?>

              </div>
            </div>
          </div>
        </div>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <br>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>
</div>

<script>
  function addNewKeypoint(id) {

    var text = '<li><input name="keypoint' + id + '[]" cols="100" rows="1" class="form-control key"></li><br>';
    $("#keypointOrder" + id + "").append(text);

  }

  function saveKeypoints(id) {
    var cboxes = document.getElementsByName('keypoint' + id + '[]');
    var action_taken = $("#action_taken" + id).val();
    var taken_by = $("#taken_by" + id).val();

    var len = cboxes.length;
    var text = "";
    var count = 0;
    for (var i = 0; i < len; i++) {
      if (count == 0) {
        text += cboxes[i].value;
      } else {
        text += "new-]" + cboxes[i].value;
      }
      count++;
    }

    var formData = {
      keypoints: text,
      action_taken: action_taken,
      taken_by: taken_by,
      "_token": "<?php echo e(csrf_token()); ?>"
    };
    var url = '/<?php echo e(env("base_url")); ?>' + 'agendas/' + id + '';


    $.ajax({
      type: "PUT",
      url: url,
      data: formData,
      success: function(data) {
        swal(data, "", "success");
      },
      erros: function(data) {
        swal(data, "", "error");
      }

    });

  }

  if ($('.checkbox:checked').length == $('.checkbox').length) {
    $("#checkAll").prop('checked', true);
  }

  $("#checkAll").click(function() {
    $(".checkbox").prop('checked', this.checked);
  });

  $(".checkbox").change(function() {
    if ($('.checkbox:checked').length == $('.checkbox').length) {
      $("#checkAll").prop('checked', true);
    } else {
      $("#checkAll").prop('checked', false);
    }
  });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/meeting/view.blade.php ENDPATH**/ ?>
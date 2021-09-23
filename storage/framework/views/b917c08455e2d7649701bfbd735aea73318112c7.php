

<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
      <h1>Meeting:<?php echo e($meeting->title); ?></h1>
      <p>Date:<?php echo e($meeting->date); ?></p>
      <p>Time:<?php echo e($meeting->time); ?></p>
      <p>Venue:<?php echo e($meeting->venue); ?></p>
      <p>Attendance <label><input type="checkbox" id="checkAll"><span>Select all</span></label></p>
      <form action="<?php echo e(route('meetings.checkAttendance')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" value="<?php echo e($meeting_id); ?>" name="meeting_id">
        <div class="d-flex flex-column">
          <?php $__currentLoopData = $group_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <label><input type="checkbox" name="attendance[]" value="<?php echo e($group_member->member_id); ?>" 
          <?php echo e($group_member->is_present?'checked':''); ?>

          class="checkbox"><span><?php echo e($group_member->members->name); ?>,<?php echo e($group_member->position); ?>

            </span></label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <div class="d-flex">
            <button class="btn btn-primary">Save</button>
            <a href="<?php echo e(route('meetings.exportPDF',$meeting_id)); ?>" target="_blank" class="btn btn-success">Generate PDF</a>
          </div>
      </form>
    </div>

    <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p><?php echo e($title->title); ?></p>
    <div class="card" style="border:1px solid black;">
      <!-- Meeting minutes -->
      <?php $__currentLoopData = $title->agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
      <div class="card-body">
        <div class="d-flex">
          <button class="btn btn-primary dropdown-toggle margin-right-5" onclick="dropDown(<?php echo e($agenda->id); ?>)" id="dropDown<?php echo e($agenda->id); ?>"><?php echo e($agenda->title); ?> (<?php echo e($agenda->users->name); ?>) </button>


        </div>



        <div id="dropdown<?php echo e($agenda->id); ?>" style="display:none">
          <div>
            Description:<?php echo e($agenda->description); ?>

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
              <li><textarea name="keypoint<?php echo e($agenda->id); ?>[]" cols="100" rows="1"><?php echo e($keypoint); ?></textarea></li>
              <?php else: ?>
              <li><?php echo e($keypoint); ?></li>
              <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button class="btn btn-success" onclick="saveKeypoints(<?php echo e($agenda->id); ?>)">Save</button>
          </div>
        </div>
      </div>


      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
</div>

<script>
  function addNewKeypoint(id) {

    var text = '<li><textarea name="keypoint' + id + '[]" cols="100" rows="1"></textarea></li>';
    $("#keypointOrder" + id + "").append(text);

  }

  function saveKeypoints(id) {
    var cboxes = document.getElementsByName('keypoint' + id + '[]');
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
      "_token": "<?php echo e(csrf_token()); ?>"
    };
    var url = '<?php echo e(env("base_url")); ?>' + 'agendas/' + id + '';


    $.ajax({
      type: "PUT",
      url: url,
      data: formData,
      success: function(data) {
        alert(data);
      }
    });

  }

  if ($('.checkbox:checked').length == $('.checkbox').length) {
      $("#checkAll").prop('checked',true);
    }

  $("#checkAll").click(function(){
    $(".checkbox").prop('checked',this.checked);
});

$(".checkbox").change(function(){
    if ($('.checkbox:checked').length == $('.checkbox').length) {
      $("#checkAll").prop('checked',true);
    }else{
      $("#checkAll").prop('checked',false);
    }
});


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\Project\minut\resources\views/meeting/view.blade.php ENDPATH**/ ?>
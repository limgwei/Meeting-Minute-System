

<?php $__env->startSection('content'); ?>

<div style="width:100%">
  <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="padding-5 bg">
    <div class="d-flex justify-content-between">
      <h5 class="inter-bold header_text"><?php echo e(__('group.members')); ?></h5>
      <?php if(!$is_admin): ?>
      <div class="d-flex justify-content-end">
        <a href="<?php echo e(route('groups.leftGroup',$group_id)); ?>" class="btn btn-default" style="color:red"><?php echo e(__('group.left_group')); ?></a>
      </div>
      <?php else: ?>
      <div class="d-flex justify-content-end" style="gap:10px;flex-grow:5">
        <input type="hidden" value="<?php echo e($group_id); ?>" id="group_id">
        <input type="text" placeholder="Gmail" id="member_gmail" class="form-control input_text" style="max-width:200px; "> <button class="btn btn-primary button_text" type="button" onclick="sendInvitation()" style="width:fit-content">Send invitation</button>
      </div>
      <?php endif; ?>
    </div>

    <!-- Group Member -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:335px;grid-gap:50px">
      <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card border_radius_12 d-flex flex-column">
        
        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="gap:20px">
          <?php if($member->members->file): ?>
          <img src="<?php echo e(asset('/storage/'.$member->members->file)); ?>" class="img-card" alt="Card image cap" style="min-width:100px;min-height:100px">
          <?php else: ?>
          <img class="img-card" src="<?php echo e(asset('/storage/icon/user.png')); ?>" alt="Card image cap" style="min-width:100px;min-height:100px">
          <?php endif; ?>
          <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="inter-bold plain_text"><?php echo e($member->members->name); ?></div>
            <div class="inter-regular plain_text"><?php echo e($member->position); ?></div>
          </div>


        </div>


      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
  </div>

</div>

<script>
  function sendInvitation() {
    var formData = {
      "email": $("#member_gmail").val(),
      "group_id": $("#group_id").val(),
      "_token": "<?php echo e(csrf_token()); ?>"
    };
    var url = '/<?php echo e(env("base_url")); ?>' + 'sendInvitation';

    $.ajax({
      method: 'POST',
      type: 'POST',
      url: url,
      data: formData,
      success: function(data) {

        if (data.status == "success") {
          swal(data.message, "", "success");
        } else {
          swal(data.message, "", "error");
        }

      },
      erros: function(data) {
        swal(data, "", "error");
      }

    });

  }
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/member.blade.php ENDPATH**/ ?>
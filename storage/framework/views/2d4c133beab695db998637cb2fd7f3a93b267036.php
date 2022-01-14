

<?php $__env->startSection('content'); ?>

<style>
  .agenda_picked {
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: white;
    border-color: #D9524F;
    border-width: 5px;
    border-radius: 50%;
  }

  .agenda_unpick {
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: white;
    border-color: #0275D8;
    border-width: 5px;
    border-radius: 50%;
  }

  .title_picked {
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: white;
    border-color: #0275D8;
    border-width: 5px;
    border-radius: 50%;
  }

  .title_unpick {
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: white;
    border-color: #0275D8;
    border-width: 1px;
    border-radius: 50%;
  }
</style>

<div class="padding-5 d-flex flex-column bg" style="gap:20px">

  <div class="inter-bold header_text"><?php echo e(__('meeting.edit_meeting')); ?></div>
  <div class="card border_radius_12" >
    <form enctype="multipart/form-data" action="<?php echo e(route('meetings.update')); ?>" method="POST" id="form" class="card-body">
      <input type="hidden" name="id" value="<?php echo e($meeting->id); ?>">
      <?php echo csrf_field(); ?>
      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('meeting.title')); ?><span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required value="<?php echo e($meeting->title); ?>">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('meeting.organiser')); ?><span class="text-danger">*</span></div>
          <select name="organiser_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              <?php $__currentLoopData = $group_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($group_member->members->id); ?>" <?php echo e($group_member->members->id==$meeting->organiser_id?"selected":""); ?>><?php echo e($group_member->members->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('meeting.secretary')); ?><span class="text-danger">*</span></div>
          <select name="secretary_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              <?php $__currentLoopData = $group_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($group_member->members->id); ?>" <?php echo e($group_member->members->id==$meeting->secreatary_id?"selected":""); ?>><?php echo e($group_member->members->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text"><?php echo e(__('meeting.location')); ?><span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="venue" required value="<?php echo e($meeting->venue); ?>">
        </div>

        <!-- time -->
        <div class="d-flex" style="gap:20px">
          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text"><?php echo e(__('meeting.date')); ?><span class="text-danger">*</span></div>
            <input type="date" class="form-control input_text" name="date" required value="<?php echo e($meeting->date); ?>">
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text"><?php echo e(__('meeting.time')); ?><span class="text-danger">*</span></div>
            <input type="time" class="form-control input_text" name="time" required value="<?php echo e($meeting->time); ?>">
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text"><?php echo e(__('meeting.duration')); ?><span class="text-danger">*</span></div>
            <div class="d-flex align-items-center" style="gap:8px">
              <input type="number" class="form-control input_text" name="hour" min='0' max='24' required value="<?php echo e($hours); ?>">
              <div class="inter-medium plain_text"><?php echo e(__('meeting.hours')); ?></div>
              <input type="number" class="form-control input_text" name="minute" min='0' max='60' required value="<?php echo e($minutes); ?>">
              <div class="inter-medium plain_text"><?php echo e(__('meeting.minutes')); ?></div>
            </div>
          </div>
        </div>
        <div class="d-flex flex-row-reverse">
          <button class="button_text btn btn-primary"> Update Meeting</button>

        </div>
      </div>
    </form>
  </div>

</div>
<script>
  function backToPending(id, select) {

    $("#hiddenID" + id).attr("name", "none");
    $("#pendingAgendaOrder").append($("#pending_agenda" + id));
    $("#addToTitle" + id).addClass("agenda_unpick");
    $("#addToTitle" + id).removeClass("agenda_picked");
    $("#addToTitle" + id).attr("onclick", "addToTitle(" + id + ")");

  }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/meeting/edit.blade.php ENDPATH**/ ?>
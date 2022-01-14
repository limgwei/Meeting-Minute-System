

<?php $__env->startSection('content'); ?>
<style>
  .date{
    background-color: orange;
    border-radius: 25px / 17px;
    left: -20px;
    border-width: 17px 17px 17px 0;
    width:max-content;padding:7px;
    height:max-content;
  }

  .time{
    height:max-content;
    background-color:  #28a745;
    border-radius: 25px / 17px;
    left: -20px;
    border-width: 17px 17px 17px 0;
    width:max-content;padding:7px;
    color:white;
  }

  .count{
    background-color:#dc3545;
    line-height: 25px;
    border-radius:25px;
    width:25px!important;
    padding:5px;
    height:25px!important;
    color:white;
  }
</style>
<div>
  <?php echo $__env->make('layouts.meetingNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="padding-5">
    <h5 class="inter-bold header_text"><?php echo e(__('layout.meeting_schedule')); ?></h5>
    <div class="card border_radius_12">
      <div class="card-body  ">

        <div class="d-flex justify-content-around">
          <div class="d-flex flex-column align-items-center">
            <div class="d-flex" style="gap:20px">
            <div class="inter-bold"><?php echo e(__('group.pending')); ?> <span class="count"><?php echo e($pending_meetings->count); ?></span></div>
            </div>
         
            <?php $__currentLoopData = $pending_meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card border_radius_12" style="min-width:300px">
              <!-- <img class=" card-img-top" src="..." alt="Card image cap"> -->
              <div class="card-body d-flex flex-column" style="gap:10px">
                <div class="font-bold"><?php echo e($meeting->title); ?></div>

                  <div class="d-flex" style="gap:12px">
                    
                    <div class="font-small date" ><?php echo e($meeting->local_date); ?></div>
                    <div class="font-small time" ><?php echo e($meeting->local_time); ?></div>
                  </div>
               
                <!-- location -->
                <div class="d-flex align-items-center" style="gap:25px">
                  <div><img  src="<?php echo e(asset('/storage/icon/geo-alt.svg')); ?>"></div>
                  <div class="d-flex flex-column" style="gap:0">
                    <div class="font-small"><?php echo e(__('group.location')); ?></div>
                    <div class="font-bold"><?php echo e($meeting->venue); ?></div>
                  </div>
                </div>

                <div class="d-flex flex-row-reverse" style="gap:25px">
                  <a href="<?php echo e(route("meetings.show",$meeting->id)); ?>"><i class="bi bi-book" style='font-size:32px;'></i>
                  </a>
                  <?php if($group_user_id == Auth::user()->id): ?>
                  <a href="<?php echo e(route("meetings.edit",$meeting->id)); ?>"> <i class="bi bi-pencil-square " style='font-size:32px;'></i></a>
                  <?php endif; ?>
                </div>




              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div>

          </div>
          <div class="d-flex flex-column align-items-center">
          <div class="d-flex" style="gap:20px">
            <div class="inter-bold"><?php echo e(__('group.pass')); ?> <span class="count"><?php echo e($pass_meetings->count); ?></span></div>
            </div>
            <?php $__currentLoopData = $pass_meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card border_radius_12" style="min-width:300px">
              <!-- <img class=" card-img-top" src="..." alt="Card image cap"> -->
              <div class="card-body d-flex flex-column" style="gap:10px">
                <div class="font-bold"><?php echo e($meeting->title); ?></div>

                  <div class="d-flex" style="gap:12px">
                    
                    <div class="font-small date" style="width:max-content;padding:5px"><?php echo e($meeting->local_date); ?></div>
                    <div class="font-small time" style="width:fit-content"><?php echo e($meeting->local_time); ?></div>
                  </div>
               
                <!-- location -->
                <div class="d-flex align-items-center" style="gap:25px">
                  <div><img src="<?php echo e(asset('/storage/icon/geo-alt.svg')); ?>"></div>
                  <div class="d-flex flex-column" style="gap:0">
                    <div class="font-small"><?php echo e(__('group.location')); ?></div>
                    <div class="font-bold"><?php echo e($meeting->venue); ?></div>
                  </div>
                </div>

                <div class="d-flex flex-row-reverse" style="gap:25px">
                  <a href="<?php echo e(route("meetings.show",$meeting->id)); ?>"><i class="bi bi-book" style='font-size:32px;'></i>
                  </a>
                  <?php if($group_user_id == Auth::user()->id): ?>
                  <a href="<?php echo e(route("meetings.edit",$meeting->id)); ?>"> <i class="bi bi-pencil-square " style='font-size:32px;'></i></a>
                  <?php endif; ?>
                </div>




              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/view.blade.php ENDPATH**/ ?>
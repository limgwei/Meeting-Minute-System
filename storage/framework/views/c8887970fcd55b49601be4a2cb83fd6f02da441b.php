<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;subset=chinese-simplified">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    body {
      font-family: 'Noto Sans SC', sans-serif;
    }
  </style>
</head>

<body>
  <div id="printThis" class="printme">

    <div>
      <h1>Meeting:<?php echo e($meeting->title); ?></h1>
      <p>Organiser:<?php echo e($meeting->organiser->name); ?></p>
      <p>Secretary:<?php echo e($meeting->secretary->name); ?></p>
      <p>Date:<?php echo e($date_text); ?></p>
      <p>Time:<?php echo e($time_text); ?></p>
      <p>Venue:<?php echo e($meeting->venue); ?></p>

      <div>
        <div>Attendance</div>
        <div class="d-flex">
          <div>Present:</div>
          <div>
            <?php $__currentLoopData = $attends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($attend->users->name); ?>,<?php echo e($attend->position); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <div class="d-flex">
          <div>Absent :</div>
          <div>
            <?php $__currentLoopData = $absents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($absent->users->name); ?>,<?php echo e($absent->position); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>


    </div>
    <?php
    $countTitle = 0;
    ?>

    <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $countTitle++;
    ?>

    <div style="padding-left:5%">
      <div>
        <h2> <?php echo e($countTitle); ?>.<?php echo e($title->title); ?></h2>
      </div>
      <div>
        <?php
        $countAgenda = 0;
        ?>

        <?php $__currentLoopData = $title->agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $countAgenda++;
        ?>

        <div style="padding-left:5%">
          <div>
            <h3> <?php echo e($countTitle); ?>.<?php echo e($countAgenda); ?>.<?php echo e($agenda->title); ?></h3>
          </div>
          <div>
            <?php echo e($agenda->description); ?>

          </div>
          <div>

            <?php
            $countKeypoint = 0;
            ?>

            <?php $__currentLoopData = $agenda->keypoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keypoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
            $countKeypoint++;
            ?>
            <?php if( $keypoint!=""): ?>
            <div style="padding-left:5%">
              <?php echo e($countTitle); ?>.<?php echo e($countAgenda); ?>.<?php echo e($countKeypoint); ?>.<?php echo e($keypoint); ?>

            </div>
            <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($agenda->action_taken): ?>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Action taken:</label>
              <div class="col-lg-6">
                <label class="col-lg-6 col-form-label"><?php echo e($agenda->action_taken); ?></label>
              </div>
            </div>  
            <?php endif; ?>
            <?php if($agenda->action_user): ?>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Taken by:</label>
              <div class="col-lg-6">
                <label class="col-lg-6 col-form-label"><?php echo e($agenda->action_user->name); ?></label>
              </div>
            </div>  
            <?php endif; ?>

  
      </div>
       
       
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\minut\resources\views/meeting/exportPDF.blade.php ENDPATH**/ ?>
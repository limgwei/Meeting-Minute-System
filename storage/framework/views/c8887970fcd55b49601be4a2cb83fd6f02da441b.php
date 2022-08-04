<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
 

</head>

<body>
  <style>
    body {
      font-family: 'Work Sans', sans-serif;
    }

    *{
      font-size:1em;
    }
  </style>
  <div id="printThis" class="printme">
    <div style="gap:30px;display:flex;flex-direction:column;margin-bottom:30px">
      <div class="inter-regular " style="color: #007bff;font-size:30px;margin-bottom:30px;text-align:center"><?php echo e($meeting->title); ?>- <?php echo e($group->title); ?></div>
      <div class="d-flex flex-column" style="margin-bottom:30px">

        <div style="margin-bottom:30px;font-size:20px;"> <b >I . MEETING DETAILS</b> </div>

        <!-- organiser and secretary -->
        <div style="margin-bottom:30px">
          <div class="inter-regular d-flex">
            <div><span style="font-size:18px">Organiser:</span>  <span style="color: #007bff"><?php echo e($meeting->organiser->name); ?></span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Secretary:</span> <span style="color: #007bff"><?php echo e($meeting->secretary->name); ?></span></div>
          </div>
        </div>

        <!-- date and time and venue -->
        <div>
          <div class="inter-regular ">
            <div><span style="font-size:18px">Date:</span> <span style="color: #007bff"><?php echo e($date_text); ?></span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Time:</span> <span style="color: #007bff"><?php echo e($time_text); ?></span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Venue:</span><span style="color: #007bff"><?php echo e($meeting->venue); ?></span></div>
          </div>
        </div>

      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b style="font-size:20px;">II . ATTENDEES</b></div>
        <div style="color: #007bff">
          <?php $__currentLoopData = $attends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($attend->users->name); ?>,
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>


      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b style="font-size:20px;"> III . ABSENCES</b></div>
        <div style="color: #007bff">
          <?php $__currentLoopData = $absents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($absent->users->name); ?>,
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold" style="margin-bottom:30px"><b style="font-size:20px;">IV . AGENDAS</b> </div>
        <div>

          <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div style="padding-left:5%;margin-bottom:30px">
            <div>
              <div style="font-size:18px"> <?php echo e($title->title); ?></div>
            </div>
            <div>

              <?php $__currentLoopData = $title->agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <div style="padding-left:5%;margin-top:40px">
                <div>
                  <b> <?php echo e($agenda->title); ?></b>
                </div>
                <div>
                  <?php echo e($agenda->description); ?>

                </div>
                <div style="margin-top:20px">
                  <b>Keypoints</b>
                  <?php echo html_entity_decode($agenda->keypoints); ?>


                  <?php if($agenda->action_taken): ?>

                  <div class="inter-regular d-flex" style="margin-top:20px">
                    <div><b>Action taken:</b>  <span style="color: #007bff"><?php echo e($agenda->action_taken); ?></span></div>
                  </div>
                  <?php endif; ?>
                  <?php if($agenda->action_user): ?>
                  <div class="inter-regular d-flex" style="margin-top:20px">
                    <div><b>Taken by:</b><span style="color: #007bff"><?php echo e($agenda->action_user->name); ?></span></div>
                    
                  </div>
                  <?php endif; ?>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>


  </div>

</body>

</html><?php /**PATH C:\xampp\htdocs\minut\resources\views/meeting/exportPDF.blade.php ENDPATH**/ ?>
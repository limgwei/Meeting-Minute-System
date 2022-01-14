<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;subset=chinese-simplified">


  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@1,900&display=swap" rel="stylesheet">

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
      <div class="inter-regular " style="color: #007bff;font-size:20px;margin-bottom:30px;text-align:center"><?php echo e($meeting->title); ?>- <?php echo e($group->title); ?></div>
      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">

        <div style="margin-bottom:30px;"> <b>I . MEETING DETAILS</b> </div>

        <!-- organiser and secretary -->
        <div style="margin-bottom:30px">
          <div class="inter-regular d-flex">
            <div>Organiser: <span style="color: #007bff"><?php echo e($meeting->organiser->name); ?></span></div>
          </div>

          <div class="inter-regular">
            <div>Secretary: <span style="color: #007bff"><?php echo e($meeting->secretary->name); ?></span></div>
          </div>
        </div>

        <!-- date and time and venue -->
        <div>
          <div class="inter-regular ">
            <div>Date: <span style="color: #007bff"><?php echo e($date_text); ?></span></div>
          </div>

          <div class="inter-regular">
            <div>Time: <span style="color: #007bff"><?php echo e($time_text); ?></span></div>
          </div>

          <div class="inter-regular">
            <div>Venue: <span style="color: #007bff"><?php echo e($meeting->venue); ?></span></div>
          </div>
        </div>

      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b>II . ATTENDEES</b></div>
        <div style="color: #007bff">
          <?php $__currentLoopData = $attends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($attend->users->name); ?>,
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>


      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b> III . ABSENCES</b></div>
        <div style="color: #007bff">
          <?php $__currentLoopData = $absents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($absent->users->name); ?>,
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b>IV . AGENDAS</b> </div>
        <div>

          <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div style="padding-left:5%">
            <div>
              <div> <?php echo e($title->title); ?></div>
            </div>
            <div>

              <?php $__currentLoopData = $title->agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <div style="padding-left:5%">
                <div>
                  <div> <?php echo e($agenda->title); ?></div>
                </div>
                <div>
                  <?php echo e($agenda->description); ?>

                </div>
                <div>
                  <?php echo html_entity_decode($agenda->keypoints); ?>


                  <?php if($agenda->action_taken): ?>

                  <div class="inter-regular d-flex" style="gap:5px">
                    <div>Action taken: <span style="color: #007bff"><?php echo e($agenda->action_taken); ?></span></div>
                  </div>
                  <?php endif; ?>
                  <?php if($agenda->action_user): ?>
                  <div class="inter-regular d-flex" style="gap:5px">
                    <div>Taken by: <span style="color: #007bff"><?php echo e($agenda->action_user->name); ?></span></div>
                    
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
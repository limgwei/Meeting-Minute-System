

<?php $__env->startSection('content'); ?>
<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->

<script src="https://cdn.tiny.cloud/1/lrk2tgho42o1v6yd85mgfrwtkfgdbmpn4auk4drvwupc7725/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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

  .mce-toc {
    border: 1px solid gray;
  }

  .mce-toc h2 {
    margin: 4px;
  }

  .mce-toc li {
    list-style-type: none;
  }

  tr{
    border:1px solid black
  }

  td{
    border:1px solid black
  }
</style>






<div class="padding-5 d-flex flex-column" style="gap:30px">
  <div class="d-flex justify-content-between align-items-center">
    <div class="inter-bold header_text"><?php echo e($meeting->title); ?></div>
    <div class="d-flex " style="gap:20px">
      <?php if($meeting->meeting_file): ?>

      <a href="<?php echo e(route('meetings.exportPDF',$meeting->id)); ?>" target="_blank" style="color:#007bff;gap:20px" class="d-flex border_radius_12 plain_text inter-bold align-items-center button_text"><img style="width:24px;height:24px" src="<?php echo e(asset('/storage/icon/export.svg')); ?>" alt=""><?php echo e(__('meeting.generate_pdf')); ?></a>

      <?php endif; ?>

      <?php if($meeting->link_opened): ?>

      <a href="<?php echo e($meeting->link); ?>" target="_blank" style="background-color:black;color:white;gap:20px;" class="d-flex border_radius_12 plain_text inter-bold align-items-center button_text"><img style="width:24px;height:24px" src="<?php echo e(asset('/storage/icon/google_meet.png')); ?>" alt=""><?php echo e(__('meeting.meeting_now')); ?></a>
      <?php endif; ?>
    </div>

  </div>

  <div class="d-flex justify-content-between" style="gap:30px">
    <div style="flex-grow:8">

      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column" style="gap:20px">
          <div class="card-title inter-bold"><?php echo e(__('meeting.information')); ?></div>

          <div style="display:grid;grid-template-columns:repeat(2,1fr);grid-auto-rows:25px;grid-gap:25px">

            <!-- local time -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="<?php echo e(asset('/storage/icon/clock.svg')); ?>" alt="">
              <div class="d-flex flex-column">
                <div class="font-small"><?php echo e(__('meeting.local_time')); ?></div>
                <div class="font-bold"><?php echo e($meeting->local_time); ?></div>
              </div>
            </div>

            <!-- organiser -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="<?php echo e(asset('/storage/icon/people.svg')); ?>" alt="">
              <div class="d-flex flex-column">
                <div class="font-small"><?php echo e(__('meeting.organiser')); ?></div>
                <div class="font-bold"><?php echo e($meeting->organiser->name); ?></div>
              </div>
            </div>

            <!-- location -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="<?php echo e(asset('/storage/icon/geo-alt.svg')); ?>">
              <div class="d-flex flex-column" style="gap:0">
                <div class="font-small"><?php echo e(__('meeting.location')); ?></div>
                <div class="font-bold"><?php echo e($meeting->venue); ?></div>
              </div>
            </div>


            <!-- secretary -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="<?php echo e(asset('/storage/icon/people.svg')); ?>" alt="">
              <div class="d-flex flex-column">
                <div class="font-small"><?php echo e(__('meeting.secretary')); ?></div>
                <div class="font-bold"><?php echo e($meeting->secretary->name); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <form action="<?php echo e(route('meetings.checkAttendance')); ?>" method="POST" id="attendanceForm" style="flex-grow:4;margin:24px 0 0 0" class="card border_radius_12">
      <input type="hidden" value="<?php echo e($meeting->id); ?>" name="meeting_id">
      <?php echo csrf_field(); ?>
      <div class="card-body d-flex flex-column" style="gap:8px">
        <div class="d-flex" style="gap:30px">
          <div class="inter-bold"><?php echo e(__('meeting.attendance')); ?></div>
          <?php if($is_admin): ?>
          <div class="d-flex align-items-center" style="gap:10px"><input type="checkbox" id="checkAll">
            <div><?php echo e(__('meeting.select_all')); ?></div>
          </div>
          <?php endif; ?>
        </div>
        <div style="overflow:auto;height:92px;gap:10px" class="d-flex flex-column">
          <?php $__currentLoopData = $meeting->member; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="d-flex align-items-center" style="gap:10px">
            <?php if($is_admin): ?>
            <input type="checkbox" name="attendance[]" value="<?php echo e($member->member_id); ?>" class="checkbox" <?php echo e($member->is_present?'checked':''); ?>>
            <?php else: ?>
            <input type="checkbox" name="attendance[]" value="<?php echo e($member->member_id); ?>" class="checkbox" <?php echo e($member->is_present?'checked':''); ?> disabled>
            <?php endif; ?>
            <span> <?php echo e($member->members->name); ?>,<?php echo e($member->position); ?></span>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php if($is_admin): ?>
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-success button_text" style="width:fit-content" onclick="submitAttendance()"><?php echo e(__('meeting.save')); ?></button>
          </div>

          <?php endif; ?>
        </div>


      </div>
    </form>
  </div>

  <div class="d-flex flex-column">
    <div class="header_text inter-bold"><?php echo e(__('meeting.agendas')); ?></div>
    <!-- bottom -->
    <div>
      <?php $__currentLoopData = $meeting->title_agenda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title_agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column" style="gap:30px">

          <div class="header_text inter-bold"><?php echo e($title_agenda->title); ?></div>
          <?php if(!($title_agenda->agenda=="[]")): ?>
          <?php $__currentLoopData = $title_agenda->agenda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card bg-light border_radius_12">
            <div class="card-body">
              <!-- header -->
              <button class="dropdown-btn d-flex justify-content-between" onclick="dropDown(<?php echo e($agenda->id); ?>)" style="width:100%">
                <div class="inter-bold plain_text"><?php echo e($agenda->title); ?>(<?php echo e($agenda->users->name); ?>)</div>
                <div><i class="bi bi-chevron-up" id="change<?php echo e($agenda->id); ?>"></i></div>
              </button>

              <!-- dropdown content -->
              <div style="gap:10px;display:none" id="dropdown<?php echo e($agenda->id); ?>">
                <?php if($agenda->description): ?>
                <!-- description -->
                <div class="d-flex">
                  <div class="plain_text"><?php echo e(__('meeting.description')); ?>:</div>
                  <div class="plain_text"><?php echo e($agenda->description); ?></div>
                </div>
                <?php endif; ?>
                <!-- Attachment file -->
                <div class="d-flex">
                  <div class="plain_text"><?php echo e(__('meeting.file')); ?>:</div>
                  <a class="plain_text" href="<?php echo e(asset('/storage/'.$agenda->file)); ?>" download><?php echo e($agenda->filename); ?></a>
                </div>

                <!-- keypoints -->
                <div class="d-flex flex-column">
                  <!-- keypoint title and button -->

                  <div class="plain_text"><?php echo e(__('meeting.keypoints')); ?>:</div>
                  <!-- keypoint in textbox -->
              <?php if($is_admin): ?>
              <textarea id="keypoint<?php echo e($agenda->id); ?>" name="keypoint<?php echo e($agenda->id); ?>" >
                  <?php echo e($agenda->keypoints); ?>

                  </textarea>
              <?php else: ?>
              <?php echo html_entity_decode($agenda->keypoints); ?>

              <?php endif; ?>
  



                </div>

                <!-- action taken -->
                <div class="d-flex flex-column">
                  <div class="plain_text"><?php echo e(__('meeting.action_taken')); ?>:</div>
                  <?php if($is_admin): ?>
                  <input type="text" name="action_taken" class="form-control input_text" id="action_taken<?php echo e($agenda->id); ?>" value="<?php echo e($agenda->action_taken); ?>">
                  <?php else: ?>
                  <div><?php echo e($agenda->action_taken); ?></div>
                  <?php endif; ?>
                </div>

                <!-- action taken by -->
                <div class="d-flex align-items-center justify-content-between" style="gap:20px">
                  <div style="flex-grow:8">
                    <div class="plain_text"><?php echo e(__('meeting.taken_by')); ?>:</div>
                    <?php if($is_admin): ?>
                    <select name="action_user_id" class="form-control select_text" id="taken_by<?php echo e($agenda->id); ?>" style="max-width:280px">

                      <optgroup style="font-size:12px">
                        <?php $__currentLoopData = $meeting->member; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($group_member->members->id); ?>" <?php echo e($group_member->members->id==$agenda->action_user_id?"selected":""); ?>><?php echo e($group_member->members->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </optgroup>


                    </select>
                    <?php else: ?>
                    <div><?php echo e($agenda->action_user_id?$agenda->action_user->name:""); ?></div>
                    <?php endif; ?>
                  </div>


                  <?php if($is_admin): ?>
                  <button class="btn btn-primary button_text d-flex flex-row-reverse" onclick="saveKeypoints(<?php echo e($agenda->id); ?>)"><?php echo e(__('meeting.save')); ?></button>
                  <?php endif; ?>
                </div>


              </div>
            </div>
          </div>


          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>


      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
  </div>



</div>
<script>
  var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

  var count = "<?php echo e(json_encode($meeting->agenda_count)); ?>";

  count_array = JSON.parse(count.replace(/&quot;/g, '"'));
  count = count_array.split(",");

  count.forEach(function(element) {
    tinymce.init({
      selector: 'textarea#keypoint' + element,
      plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen  link template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap  emoticons',
      menubar: 'edit view format tools table help',
      toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | media template link anchor codesample | ltr rtl',
      toolbar_sticky: true,
      autosave_ask_before_unload: true,
      autosave_interval: '30s',
      autosave_prefix: '{path}{query}-{id}-',
      autosave_restore_when_empty: false,
      autosave_retention: '2m',

      link_list: [{
          title: 'My page 1',
          value: 'https://www.tiny.cloud'
        },
        {
          title: 'My page 2',
          value: 'http://www.moxiecode.com'
        }
      ],
      importcss_append: true,
      file_picker_callback: function(callback, value, meta) {
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
          callback('https://www.google.com/logos/google.jpg', {
            text: 'My text'
          });
        }


        /* Provide alternative source and posted for the media dialog */
        if (meta.filetype === 'media') {
          callback('movie.mp4', {
            source2: 'alt.ogg',
            poster: 'https://www.google.com/logos/google.jpg'
          });
        }
      },
      templates: [{
          title: 'New Table',
          description: 'creates a new table',
          content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
        },
        {
          title: 'Starting my story',
          description: 'A cure for writers block',
          content: 'Once upon a time...'
        },
        {
          title: 'New list with dates',
          description: 'New List with dates',
          content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
        }
      ],
      template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
      template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
      height: 300,
      quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote  quicktable',
      noneditable_noneditable_class: 'mceNonEditable',
      toolbar_mode: 'sliding',
      contextmenu: 'table',
      skin: useDarkMode ? 'oxide-dark' : 'oxide',
      content_css: useDarkMode ? 'dark' : 'default',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

  })
</script>


<script>
  function dropDown(number) {

    var currentStatus = $("#dropdown" + number).css("display");

    if (currentStatus == "none") {
      $("#dropdown" + number).css("display", "flex");
      $("#dropdown" + number).css("flex-direction", "column");

      $("#change" + number).removeClass('bi-chevron-up');
      $("#change" + number).addClass('bi-chevron-down');
    } else {
      $("#dropdown" + number).css("display", "none");
      $("#change" + number).removeClass('bi-chevron-down');
      $("#change" + number).addClass('bi-chevron-up');
    }

  }



  function saveKeypoints(id) {

    tinymce.triggerSave();
    var text = $("textarea#keypoint" + id).val();
    var action_taken = $("#action_taken" + id).val();
    var taken_by = $("#taken_by" + id).val();

    var formData = {
      keypoints: text,
      action_taken: action_taken,
      action_user_id: taken_by,
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
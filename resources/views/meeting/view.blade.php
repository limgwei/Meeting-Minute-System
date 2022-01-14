@extends('layouts.app')

@section('content')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


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
    <div class="inter-bold header_text">{{$meeting->title}}</div>
    <div class="d-flex " style="gap:20px">
      @if($meeting->meeting_file)

      <a href="{{route('meetings.exportPDF',$meeting->id)}}" target="_blank" style="color:#007bff;gap:20px" class="d-flex border_radius_12 plain_text inter-bold align-items-center button_text"><img style="width:24px;height:24px" src="{{asset('/storage/icon/export.svg')}}" alt="">{{ __('meeting.generate_pdf') }}</a>

      @endif

      @if($meeting->link_opened)

      <a href="{{$meeting->link}}" target="_blank" style="background-color:black;color:white;gap:20px;" class="d-flex border_radius_12 plain_text inter-bold align-items-center button_text"><img style="width:24px;height:24px" src="{{asset('/storage/icon/google_meet.png')}}" alt="">{{ __('meeting.meeting_now') }}</a>
      @endif
    </div>

  </div>

  <div class="d-flex justify-content-between" style="gap:30px">
    <div style="flex-grow:8">

      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column" style="gap:20px">
          <div class="card-title inter-bold">{{ __('meeting.information') }}</div>

          <div style="display:grid;grid-template-columns:repeat(2,1fr);grid-auto-rows:25px;grid-gap:25px">

            <!-- local time -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="{{asset('/storage/icon/clock.svg')}}" alt="">
              <div class="d-flex flex-column">
                <div class="font-small">{{ __('meeting.local_time') }}</div>
                <div class="font-bold">{{$meeting->local_time}}</div>
              </div>
            </div>

            <!-- organiser -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="{{asset('/storage/icon/people.svg')}}" alt="">
              <div class="d-flex flex-column">
                <div class="font-small">{{ __('meeting.organiser') }}</div>
                <div class="font-bold">{{$meeting->organiser->name}}</div>
              </div>
            </div>

            <!-- location -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="{{asset('/storage/icon/geo-alt.svg')}}">
              <div class="d-flex flex-column" style="gap:0">
                <div class="font-small">{{ __('meeting.location') }}</div>
                <div class="font-bold">{{$meeting->venue}}</div>
              </div>
            </div>


            <!-- secretary -->
            <div class="d-flex align-items-center" style="gap:10px">
              <img class="icon" src="{{asset('/storage/icon/people.svg')}}" alt="">
              <div class="d-flex flex-column">
                <div class="font-small">{{ __('meeting.secretary') }}</div>
                <div class="font-bold">{{$meeting->secretary->name}}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <form action="{{route('meetings.checkAttendance')}}" method="POST" id="attendanceForm" style="flex-grow:4;margin:24px 0 0 0" class="card border_radius_12">
      <input type="hidden" value="{{$meeting->id}}" name="meeting_id">
      @csrf
      <div class="card-body d-flex flex-column" style="gap:8px">
        <div class="d-flex" style="gap:30px">
          <div class="inter-bold">{{ __('meeting.attendance') }}</div>
          @if($is_admin)
          <div class="d-flex align-items-center" style="gap:10px"><input type="checkbox" id="checkAll">
            <div>{{ __('meeting.select_all') }}</div>
          </div>
          @endif
        </div>
        <div style="overflow:auto;height:92px;gap:10px" class="d-flex flex-column">
          @foreach($meeting->member as $member)
          <div class="d-flex align-items-center" style="gap:10px">
            @if($is_admin)
            <input type="checkbox" name="attendance[]" value="{{$member->member_id}}" class="checkbox" {{$member->is_present?'checked':''}}>
            @else
            <input type="checkbox" name="attendance[]" value="{{$member->member_id}}" class="checkbox" {{$member->is_present?'checked':''}} disabled>
            @endif
            <span> {{$member->members->name}},{{$member->position}}</span>
          </div>
          @endforeach

          @if($is_admin)
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-success button_text" style="width:fit-content" onclick="submitAttendance()">{{ __('meeting.save') }}</button>
          </div>

          @endif
        </div>


      </div>
    </form>
  </div>

  <div class="d-flex flex-column">
    <div class="header_text inter-bold">{{ __('meeting.agendas') }}</div>
    <!-- bottom -->
    <div>
      @foreach ($meeting->title_agenda as $title_agenda)
      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column" style="gap:30px">

          <div class="header_text inter-bold">{{$title_agenda->title}}</div>
          @if(!($title_agenda->agenda=="[]"))
          @foreach($title_agenda->agenda as $agenda)
          <div class="card bg-light border_radius_12">
            <div class="card-body">
              <!-- header -->
              <button class="dropdown-btn d-flex justify-content-between" onclick="dropDown({{$agenda->id}})" style="width:100%">
                <div class="inter-bold plain_text">{{$agenda->title}}({{$agenda->users->name}})</div>
                <div><i class="bi bi-chevron-up" id="change{{$agenda->id}}"></i></div>
              </button>

              <!-- dropdown content -->
              <div style="gap:10px;display:none" id="dropdown{{$agenda->id}}">
                @if($agenda->description)
                <!-- description -->
                <div class="d-flex">
                  <div class="plain_text">{{ __('meeting.description') }}:</div>
                  <div class="plain_text">{{$agenda->description}}</div>
                </div>
                @endif
                <!-- Attachment file -->
                <div class="d-flex">
                  <div class="plain_text">{{ __('meeting.file') }}:</div>
                  <a class="plain_text" href="{{asset('/storage/'.$agenda->file)}}" download>{{$agenda->filename}}</a>
                </div>

                <!-- keypoints -->
                <div class="d-flex flex-column">
                  <!-- keypoint title and button -->

                  <div class="plain_text">{{ __('meeting.keypoints') }}:</div>
                  <!-- keypoint in textbox -->
              @if($is_admin)
              <textarea id="keypoint{{$agenda->id}}" name="keypoint{{$agenda->id}}" >
                  {{$agenda->keypoints}}
                  </textarea>
              @else
              {!! html_entity_decode($agenda->keypoints) !!}
              @endif
  



                </div>

                <!-- action taken -->
                <div class="d-flex flex-column">
                  <div class="plain_text">{{ __('meeting.action_taken') }}:</div>
                  @if($is_admin)
                  <input type="text" name="action_taken" class="form-control input_text" id="action_taken{{$agenda->id}}" value="{{$agenda->action_taken}}">
                  @else
                  <div>{{$agenda->action_taken}}</div>
                  @endif
                </div>

                <!-- action taken by -->
                <div class="d-flex align-items-center justify-content-between" style="gap:20px">
                  <div style="flex-grow:8">
                    <div class="plain_text">{{ __('meeting.taken_by') }}:</div>
                    @if($is_admin)
                    <select name="action_user_id" class="form-control select_text" id="taken_by{{$agenda->id}}" style="max-width:280px">

                      <optgroup style="font-size:12px">
                        @foreach($meeting->member as $group_member)
                        <option value="{{$group_member->members->id}}" {{$group_member->members->id==$agenda->action_user_id?"selected":""}}>{{$group_member->members->name}}</option>
                        @endforeach
                      </optgroup>


                    </select>
                    @else
                    <div>{{$agenda->action_user_id?$agenda->action_user->name:""}}</div>
                    @endif
                  </div>


                  @if($is_admin)
                  <button class="btn btn-primary button_text d-flex flex-row-reverse" onclick="saveKeypoints({{$agenda->id}})">{{ __('meeting.save') }}</button>
                  @endif
                </div>


              </div>
            </div>
          </div>


          @endforeach
          @endif
        </div>


      </div>
      @endforeach

    </div>
  </div>



</div>
<script>
  var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

  var count = "{{ json_encode($meeting->agenda_count) }}";

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
      "_token": "{{ csrf_token() }}"
    };
    var url = '/{{env("base_url")}}' + 'agendas/' + id + '';


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
@endsection
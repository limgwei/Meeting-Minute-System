@extends('layouts.app')

@section('content')


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
      <h1>Meeting:{{$meeting->title}}</h1>
      <p>Date:{{$meeting->date}}</p>
      <p>Time:{{$meeting->time}}</p>
      <p>Venue:{{$meeting->venue}}</p>
      <p>Organiser:{{$meeting->organiser->name}}</p>
      <p>Secretary:{{$meeting->secretary->name}}</p>
      @if($is_admin)
      <p>Attendance <label><input type="checkbox" id="checkAll"><span>Select all</span></label></p>
      <form action="{{route('meetings.checkAttendance')}}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" value="{{$meeting_id}}" name="meeting_id">
        <div class="d-flex flex-column">
          @foreach($group_members as $group_member)
          <label><input type="checkbox" name="attendance[]" value="{{$group_member->member_id}}" {{$group_member->is_present?'checked':''}} class="checkbox"><span>{{$group_member->members->name}},{{$group_member->position}}
            </span></label>
          @endforeach
          <div class="d-flex">
          <button class="btn btn-primary" onclick="submitAttendance()">Save</button>
            @endif
            @if($meeting->meeting_file)
            <a href="{{route('meetings.exportPDF',$meeting_id)}}" target="_blank" class="btn btn-success">Generate PDF</a>
            @endif
          </div>
        </div>
      </form>

    </div>
    <div class="d-flex flex-column" style="width:100%">
      @foreach ($titles as $title)

      <div class="" style="padding:5% 5% 5% 5%;background-color:#f8f9fa;border-radius:12px">
        <h2>{{$title->title}}</h2>
        <!-- Meeting minutes -->
        @foreach($title->agendas as $agenda)

        <div class="card-body">
          <div>
            <button class="dropdown-btn margin-right-5 d-flex justify-content-between" onclick="dropDown({{$agenda->id}})" id="dropDown{{$agenda->id}}" style="text-align:left;width:100%"><span><b> {{$agenda->title}}</b> ({{$agenda->users->name}})</span> <span><img src="{{asset('/storage/image/dropup.png')}}" style="width:16px;height:16px" id="icon{{$agenda->id}}"></span> </button>




            <div id="dropdown{{$agenda->id}}" style="display:none">
              <div>
                <p>{{$agenda->description}}</p>
              </div>
              <div>
                Attachment File
                <a href="{{asset('/storage/'.$agenda->file)}}" download>{{$agenda->filename}}</a>
              </div>
              <div>
                Key points
                @if($is_admin)
                <button class="btn btn-success" onclick="addNewKeypoint({{$agenda->id}})">Add New</button>
                @endif

                <ul id="keypointOrder{{$agenda->id}}">
                  @foreach($agenda->keypoints as $keypoint)
                  @if($is_admin)
                  <li><input name="keypoint{{$agenda->id}}[]" cols="100" rows="1" class="form-control key" value="{{$keypoint}}" style="border-radius:8px"></li>
                  <br>
                  @else
                  <li>{{$keypoint}}</li>
                  @endif
                  @endforeach
                </ul>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Action taken:</label>
                  <div class="col-lg-12">
                    @if($is_admin)
                    <input type="text" name="action_taken" class="form-control" id="action_taken{{$agenda->id}}" value="{{$agenda->action_taken}}">

                    @else
                    @if($agenda->action_taken)
                    <div class="form-control">{{$agenda->action_taken}}</div>
                    @endif
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Taken by:</label>
                  @if($is_admin)
                  <select name="action_user_id" class="form-control form-control-lg" id="taken_by{{$agenda->id}}" style="width:50%">
                    @foreach($group_members as $group_member)
                    <option value="{{$group_member->members->id}}" {{$group_member->members->id==$agenda->action_user_id?"selected":""}}>{{$group_member->members->name}}</option>
                    @endforeach

                  </select>
                  @else
                  @if($agenda->action_user)
                  <div class="form-control">{{$agenda->action_user->name}}</div>
                  @endif

                  @endif


                </div>
                @if($is_admin)

                <button class="btn btn-success" style="" onclick="saveKeypoints({{$agenda->id}})">Save</button>

                @endif

              </div>
            </div>
          </div>
        </div>


        @endforeach
      </div>
      <br>
      @endforeach
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
@extends('layouts.app')

@section('content')

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

  <div class="inter-bold header_text">{{ __('meeting.edit_meeting') }}</div>
  <div class="card border_radius_12" >
    <form enctype="multipart/form-data" action="{{route('meetings.update')}}" method="POST" id="form" class="card-body">
      <input type="hidden" name="id" value="{{$meeting->id}}">
      @csrf
      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.title') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required value="{{$meeting->title}}">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.organiser') }}<span class="text-danger">*</span></div>
          <select name="organiser_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              @foreach($group_members as $group_member)
              <option value="{{$group_member->members->id}}" {{$group_member->members->id==$meeting->organiser_id?"selected":""}}>{{$group_member->members->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.secretary') }}<span class="text-danger">*</span></div>
          <select name="secretary_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              @foreach($group_members as $group_member)
              <option value="{{$group_member->members->id}}" {{$group_member->members->id==$meeting->secreatary_id?"selected":""}}>{{$group_member->members->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.location') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="venue" required value="{{$meeting->venue}}">
        </div>

        <!-- time -->
        <div class="d-flex" style="gap:20px">
          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.date') }}<span class="text-danger">*</span></div>
            <input type="date" class="form-control input_text" name="date" required value="{{$meeting->date}}">
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.time') }}<span class="text-danger">*</span></div>
            <input type="time" class="form-control input_text" name="time" required value="{{$meeting->time}}">
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.duration') }}<span class="text-danger">*</span></div>
            <div class="d-flex align-items-center" style="gap:8px">
              <input type="number" class="form-control input_text" name="hour" min='0' max='24' required value="{{$hours}}">
              <div class="inter-medium plain_text">{{ __('meeting.hours') }}</div>
              <input type="number" class="form-control input_text" name="minute" min='0' max='60' required value="{{$minutes}}">
              <div class="inter-medium plain_text">{{ __('meeting.minutes') }}</div>
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

@endsection
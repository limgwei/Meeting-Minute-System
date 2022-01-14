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

<div class="padding-5 d-flex flex-column" style="gap:20px">

  <div class="inter-bold header_text">{{ __('meeting.create_meeting') }}</div>
  <div class="card border_radius_12" style="margin:0">
    <form enctype="multipart/form-data" action="{{route('meetings.store')}}" method="POST" id="form" class="card-body">

      <input type="hidden" name="count" id="countTitle">
      <input type="hidden" name="group_id" value="{{$group_id}}">
      @csrf
      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.title') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.organiser') }}<span class="text-danger">*</span></div>
          <select name="organiser_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              @foreach($group_members as $group_member)
              <option value="{{$group_member->members->id}}">{{$group_member->members->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.secretary') }}<span class="text-danger">*</span></div>
          <select name="secretary_id" class="form-control select_text">
            <optgroup style="font-size:12px">
              @foreach($group_members as $group_member)
              <option value="{{$group_member->members->id}}">{{$group_member->members->name}}</option>
              @endforeach
            </optgroup>
          </select>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('meeting.location') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="venue" required>
        </div>

        <!-- time -->
        <div class="d-flex" style="gap:20px">
          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.date') }}<span class="text-danger">*</span></div>
            <input type="date" class="form-control input_text" name="date" required>
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.time') }}<span class="text-danger">*</span></div>
            <input type="time" class="form-control input_text" name="time" required>
          </div>

          <div class="d-flex flex-column" style="gap:8px">
            <div class="inter-medium plain_text">{{ __('meeting.duration') }}<span class="text-danger">*</span></div>
            <div class="d-flex align-items-center" style="gap:8px">
              <input type="number" class="form-control input_text" name="hour" min='0' max='24' required>
              <div class="inter-medium plain_text">{{ __('meeting.hours') }}</div>
              <input type="number" class="form-control input_text" name="minute" min='0' max='60' required>
              <div class="inter-medium plain_text">{{ __('meeting.minutes') }}</div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column" style="gap:30px">
          <div class="d-flex flex-column" style="gap:10px">
            <div class="inter-medium plain_text">{{ __('meeting.agenda_selection') }}</div>
            <div class="d-flex" style="gap:20px">
              <button class="btn btn-primary button_text" style="width:fit-content" onclick="addNewTitle()" type="button">{{ __('meeting.add_title') }}</button>
              <button type="submit" class="btn btn-primary button_text">{{ __('meeting.create_meeting') }}</button>
            </div>
          </div>


          <!-- agenda -->
          <div style="display:grid;grid-template-columns:repeat(2,1fr)">
            <div class="d-flex flex-column" style="gap:15px">
              <!-- title agenda -->
              <div id="titleOrder" class="d-flex flex-column" style="gap:10px"></div>
            </div>
            <!-- pending agenda -->
            <div class="d-flex flex-column" style="gap:10px" id="pendingAgendaOrder">
              @foreach($pending_agendas as $pending_agenda)
              <div class="d-flex" id="pending_agenda{{$pending_agenda->id}}">
                <input type="hidden" value="{{$pending_agenda->id}}" id="hiddenID{{$pending_agenda->id}}">
                <button class="agenda_unpick" onclick="addToTitle({{$pending_agenda->id}})" id="addToTitle{{$pending_agenda->id}}" type="button"></button>
                <div>{{$pending_agenda->title}}</div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

</div>
<script>
  var select = 0;
  var count = 0;

  addNewTitle();

  function addNewTitle() {
    count++;
    var text = "";
    $("#countTitle").val(count);
    if (count == 1) {
      text += '<div class="d-flex flex-column" style="gap:20px"><div class="d-flex align-items-center" style="gap:20px" ><button class="title_unpick" type = "button" onclick="selectThis(' + count + ')" id="titleSelected' + count + '"></button><div><input type="text" class="form-control form-control-sm" name="title' + count + '" id="title' + count + '" value="Introduction"></div></div> <div class="d-flex flex-column" style="margin-left:20px;gap:15px" id="pending_agendaOrder' + count + '"></div></div>';
    } else {
      text += '<div class="d-flex flex-column" style="gap:20px"><div class="d-flex align-items-center" style="gap:20px" ><button class="title_unpick" type = "button" onclick="selectThis(' + count + ')" id="titleSelected' + count + '"></button><div><input type="text" class="form-control form-control-sm" name="title' + count + '" id="title' + count + '"></div></div> <div class="d-flex flex-column" style="margin-left:20px;gap:15px" id="pending_agendaOrder' + count + '"></div></div>';
    }


    $("#titleOrder").append(text);
    if (count == 1) {
      selectThis(1);
    }
  }

  function selectThis(id) {
    $("#titleSelected" + select).removeClass("title_picked");
    $("#titleSelected" + select).addClass("title_unpick");
    select = id;
    $("#titleSelected" + select).removeClass("title_unpick");
    $("#titleSelected" + select).addClass("title_picked");
  }

  function addToTitle(id) {
    //  array[select-1].currentID.push(id); 
    //  console.log(array);
    if (select != 0) {
      $("#hiddenID" + id).attr("name", "title" + select + "Item[]");
      $("#pending_agendaOrder" + select).append($("#pending_agenda" + id));
      $("#addToTitle" + id).removeClass("agenda_unpick");
      $("#addToTitle" + id).addClass("agenda_picked");
      $("#addToTitle" + id).attr("onclick", "backToPending('" + id + "', '" + select + "')");
    }

  }

  function backToPending(id, select) {

    $("#hiddenID" + id).attr("name", "none");
    $("#pendingAgendaOrder").append($("#pending_agenda" + id));
    $("#addToTitle" + id).addClass("agenda_unpick");
    $("#addToTitle" + id).removeClass("agenda_picked");
    $("#addToTitle" + id).attr("onclick", "addToTitle(" + id + ")");

  }
</script>

@endsection
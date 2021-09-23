@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="d-flex flex-column" style="width:100%">
      <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
          <div class="page-title d-flex">
            <h4>
              <span class="font-weight-bold mr-2">Create</span>
              <i class="icon-circle-right2 mr-2"></i>
              <span class="font-weight-bold mr-2">Meeting</span>
            </h4>
          </div>
        </div>
      </div>

      <div class="content">
        <div>
          <form enctype="multipart/form-data" action="{{route('meetings.store')}}" method="POST" id="form">
            <div class="card">
              <div class="card-body">
                <input type="hidden" name="count" id="countTitle">
                @csrf
                <input type="hidden" name="group_id" value="{{$group_id}}">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-address-book mr-2"></i>
                </legend>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Title:</label>
                  <div class="col-lg-9">
                    <input value="" type="text" class="form-control form-control-lg" name="title" placeholder="Title" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Organiser:</label>
                  <div class="col-lg-9">
                    <select name="organiser_id" class="form-control form-control-lg">
                      @foreach($group_members as $group_member)
                        <option value="{{$group_member->members->id}}">{{$group_member->members->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Secretary:</label>
                  <div class="col-lg-9">
                    <select name="secretary_id" class="form-control form-control-lg">
                    @foreach($group_members as $group_member)
                        <option value="{{$group_member->members->id}}">{{$group_member->members->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Date:</label>
                  <div class="col-lg-9">
                    <input value="" type="date" class="form-control form-control-lg" name="date" placeholder="Date">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Time:</label>
                  <div class="col-lg-9">
                    <input value="" type="time" class="form-control form-control-lg" name="time">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Venue:</label>
                  <div class="col-lg-9">
                    <input value="" type="text" class="form-control form-control-lg" name="venue">
                  </div>
                </div>


              </div>
            </div>
            <div class="d-flex justify-content-between" style="border:1px solid black">
              <div style="width:50%">
                <div class="card">
                  <div class="card-body">

                    <div class="form-group row">
                      <button class="btn btn-success" type="button" onclick="addNewTitle({{$group_id}})">Add New Title</button>
                    </div>

                  </div>
                  
                  <div class="" id="titleOrder">
                    </div>
                </div>
              </div>
              <!-- left -->
              <div style="width:50%">
                <div class="card">
                  <div class="card-body" id="pendingAgendaOrder">
                    @foreach($pending_agendas as $pending_agenda)
                    <div id="pending_agenda{{$pending_agenda->id}}" style="border:1px solid black;margin:5%">
                    <input type="hidden" value="{{$pending_agenda->id}}" id="hiddenID{{$pending_agenda->id}}">
                      <button class="btn btn-primary margin-right-5" onclick="addToTitle({{$pending_agenda->id}})" id="addToTitle{{$pending_agenda->id}}" type="button">{{$pending_agenda->title}} ({{$pending_agenda->users->name}}) </button>
                      <div>
                        Description:{{$pending_agenda->description}}
                      </div>
                      <div>
                        Attachment File: <a href="{{asset('/storage/'.$pending_agenda->file)}}" download>{{$pending_agenda->filename}}</a>
                      </div>
                    </div>
                    @endforeach

                  </div>
                </div>
              </div>
              <!-- right -->
            </div>
            <div class="text-right" style="float:right">
              <button type="submit" class="btn btn-success">
                Create
                <i class="icon-database-insert ml-1"></i>
              </button>
            </div>
          </form>



        </div>

      </div>
    </div>
  </div>
</div>

<script>
  var select = 0;
  var count = 0;



  function addNewTitle(id) {
    count++;
    
    $("#countTitle").val(count);

    var text = '<div class="d-flex flex-column" ><div class="d-flex" style="padding:5%" id="titleSelected'+count+'"><input value="" type="text" class="form-control form-control-lg" name="title'+count+'" placeholder="Title" id="title' + count + '"> <button class="btn btn-primary" type = "button" onclick="selectThis(' + count + ')">Select</button></div><div id="pending_agendaOrder' + count + '"></div></div>';
    $("#titleOrder").append(text);
  }

  function selectThis(id) {
    $("#titleSelected" + select).css("background-color", "white");
    select = id;
    $("#titleSelected" + select).css("background-color", "greenyellow");
  }

  function addToTitle(id) {
  //  array[select-1].currentID.push(id); 
  //  console.log(array);
    $("#hiddenID"+id).attr("name","title"+select+"Item[]");
    $("#pending_agendaOrder" + select).append($("#pending_agenda" + id));
    $("#addToTitle" + id).attr("onclick", "backToPending('"+id+"', '"+select+"')");
  }

  function backToPending(id,select) {
 
    $("#hiddenID"+id).attr("name","none");
    $("#pendingAgendaOrder").append($("#pending_agenda" + id));
    $("#addToTitle" + id).attr("onclick", "addToTitle(" + id + ")");

  }
</script>

@endsection
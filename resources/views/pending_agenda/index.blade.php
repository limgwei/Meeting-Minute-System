@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    @include('layouts.meetingNav') 

      <a href="{{route("pending_agendas.add",$group_id)}}" class="btn btn-success">Add Agenda</a>
      @if($create_meeting)
      <a href="{{route("meetings.create",$group_id)}}" class="btn btn-success">Create Meeting</a>
      @endif

      <!-- Meeting minutes -->
      @foreach($pending_agendas as $pending_agenda)
      <div class="card" style="border:1px solid black;">
        <div class="card-body">
          <div class="">
            <button class="btn btn-primary">{{$pending_agenda->title}} ({{$pending_agenda->users->name}}) </button>
            <div>
              <div>
                Description:{{$pending_agenda->description}}
              </div>
              <div>
                Attachment File
                <a href="{{asset('/storage/'.$pending_agenda->file)}}" download>{{$pending_agenda->filename}}</a>
              </div>
              @if($pending_agenda->editable)
              <a href="{{route('pending_agendas.view',$pending_agenda->id)}}" class="btn btn-primary">Edit</a>
              @endif
              <a href="" class="btn btn-success">View</a>
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>


  @endsection
@extends('layouts.app')

@section('content')
<div class="d-flex flex-column" style="gap:10px">
  @include('layouts.meetingNav')
  <div class="padding-5 d-flex flex-column">
    <div class="d-flex justify-content-between">
      <div class="inter-bold header_text">{{ __('pending_agenda.pending_agenda') }}</div>
      <div class="d-flex ">
        @if($create_meeting)
        <a href="{{route("meetings.create",$group_id)}}" class="btn btn-default button_text">{{ __('pending_agenda.create_meeting') }}</a>
        @endif
        <a href="{{route("pending_agendas.add",$group_id)}}" class="btn btn-primary button_text">{{ __('pending_agenda.add_agenda') }}</a>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:275px;grid-gap:50px">
      @foreach ($pending_agendas as $pending_agenda)
      <div class="card border_radius_12" style="margin:24px 0 0 0">
        <div class="card-body d-flex flex-column justify-content-between">
          <div class="d-flex flex-column" style="gap:10px">
            <div class="d-flex" style="gap:30px">
              <div> @if($pending_agenda->users->file)
                <img src="{{asset('/storage/'.$pending_agenda->users->file)}}" class="img-card" alt="Card image cap" style="width:50px;height:50px">
                @else
                <img class="img-card" src="{{asset('/storage/icon/user.png')}}" alt="Card image cap" style="width:50px;height:50px">
                @endif
              </div>
              <div class="d-flex flex-column">
                <div class="inter-bold">{{$pending_agenda->users->name}}</div>
                <div class="inter-regular plain_text">{{$pending_agenda->position}}</div>
              </div>

            </div>
            <div class="d-flex flex-column" style="gap:10px">
              <div class="plain_text">TITLE: <span class="inter-bold">{{$pending_agenda->title}}</span> </div>
              <div class="plain_text">{{$pending_agenda->description}} </div>
              <div class="plain_text">{{ __('pending_agenda.file') }}: <span class="inter-bold"><a href="{{asset('/storage/'.$pending_agenda->file)}}" download>{{$pending_agenda->filename}}</a></span> </div>

            </div>
          </div>

          @if($pending_agenda->editable)
          <a style="color:white;" href="{{route('pending_agendas.view',$pending_agenda->id)}}">
          <div class="btn btn-primary button_text d-flex justify-content-center">
            EDIT
          </div>
          </a>
          @endif

        </div>
      </div>
      
      @endforeach
    </div>
  </div>
</div>


</div>
@endsection
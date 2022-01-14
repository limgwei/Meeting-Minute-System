@extends('layouts.app')

@section('content')
<script src="{{ asset('js/change_group.js') }}"></script>
<div class="padding-5 d-flex flex-column" style="gap:20px">
  <div class="inter-bold header_text">
    <a href="{{route("pending_agendas.index",$pending_agenda->group_id)}}"><i class="bi bi-arrow-left-circle" style="font-size:24px"></i> </a>{{ __('pending_agenda.update') }}
  </div>
  <div class="card border_radius_12">
    <form class="card-body" enctype="multipart/form-data" action="{{route('pending_agendas.update')}}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{$pending_agenda->id}}">

      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.title') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required value="{{$pending_agenda->title}}" maxlength="20">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.description') }}</div>
          <input type="text" class="form-control input_text" name="description" required value="{{$pending_agenda->description}}" maxlength="20">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.file') }}<span class="text-danger">*</span></div>
          <input type="file" class="form-control form-control-lg" name="file" accept=".pdf">
          <div class="plain_text">{{ __('pending_agenda.original_file') }}: <span class="inter-bold"><a href="{{asset('/storage/'.$pending_agenda->file)}}" download>{{$pending_agenda->filename}}</a></span> </div>
        </div>

        <div class="d-flex flex-row-reverse " >
          <button type="submit" class="btn btn-primary button_text">
            {{ __('pending_agenda.update') }}</i>
          </button>
        </div>

      </div>

    </form>
  </div>
</div>


@endsection
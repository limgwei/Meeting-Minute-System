@extends('layouts.app')

@section('content')
<script src="{{ asset('js/change_group.js') }}"></script>
<div class="padding-5 d-flex flex-column" style="gap:20px">
  <div class="inter-bold header_text">
    <a href="{{route("pending_agendas.index",$group_id)}}"><i class="bi bi-arrow-left-circle" style="font-size:24px"></i> </a>{{ __('pending_agenda.add_agenda') }}
  </div>
  <div class="card border_radius_12">
    <form class="card-body" enctype="multipart/form-data" action="{{route('pending_agendas.store')}}" method="POST">
      @csrf
      <input type="hidden" name="group_id" value="{{$group_id}}">

      <div class="d-flex flex-column" style="gap:20px">

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.title') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="title" required maxlength="20">
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.description') }}</div>
          <input type="text" class="form-control input_text" name="description" required >
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('pending_agenda.file') }}<span class="text-danger">*</span></div>
          <input value="" type="file" class="form-control form-control-lg" name="file" accept=".pdf" maxlength="20">
        </div>

        <div class="d-flex flex-row-reverse " >
          <button type="submit" class="btn btn-primary button_text">
            {{ __('pending_agenda.create_agenda') }}</i>
          </button>
        </div>

      </div>

    </form>
  </div>
</div>


@endsection
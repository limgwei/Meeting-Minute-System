@extends('layouts.app')

@section('content')
<div class="padding-5">

  <h5 class="inter-bold header_text">
    {{ __('setting.notification') }}
  </h5>

  <div class="card border_radius_12" style="margin:24px 0 0 0">
    <div class="card-body">
      <div>

        @foreach($invitations as $invitation)
        @if($invitation->is_approve!=0)

        <div class="card border_radius_12 padding-5 {{$invitation->is_seen==1?'bg-light':''}} border_radius_12">
          <div class="inter-medium"><span class="inter-bold">{{$invitation->receiver->name}}</span> has {{$invitation->is_approve==1?'accepted':'rejected'}} your invitation to <span class="inter-bold">{{$invitation->group->title}}</span></div>
        </div>
        @else
        <div class="card border_radius_12 padding-5 {{$invitation->is_seen==1?'bg-light':''}}">
          <div class="inter-medium"><span class="inter-bold">{{$invitation->sender->name}}</span> has invited you to join <span class="inter-bold">{{$invitation->group->title}}</span> </div>
          <div class="d-flex justify-content-end" style="gap:10px">
            <a href="{{route('invitation.reply',[$invitation->id,1])}}" class="btn btn-success">Accept</a>
            <a href="{{route('invitation.reply',[$invitation->id,2])}}" class="btn btn-danger">Reject</a>
          </div>
        </div>
        @endif

        @endforeach

      </div>
    </div>
  </div>

</div>

<script>
  $("#notification").remove();
  var url = '/{{env("base_url")}}' + 'notification/update';
  $.ajax({
    type: "GET",
    url: url,
    success: function(data) {

    },
    erros: function(data) {
      console.log(data);
    }
  });
</script>
@endsection
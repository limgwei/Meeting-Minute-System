@extends('layouts.app')

@section('content')

<div style="width:100%">
  @include('layouts.meetingNav')
  <div class="padding-5 bg">
    <div class="d-flex justify-content-between">
      <h5 class="inter-bold header_text">{{ __('group.members') }}</h5>
      @if(!$is_admin)
      <div class="d-flex justify-content-end">
        <a href="{{route('groups.leftGroup',$group_id)}}" class="btn btn-default" style="color:red">{{ __('group.left_group') }}</a>
      </div>
      @else
      <div class="d-flex justify-content-end" style="gap:10px;flex-grow:5">
        <input type="hidden" value="{{$group_id}}" id="group_id">
        <input type="text" placeholder="Gmail" id="member_gmail" class="form-control input_text" style="max-width:200px; "> <button class="btn btn-primary button_text" type="button" onclick="sendInvitation()" style="width:fit-content">Send invitation</button>
      </div>
      @endif
    </div>

    <!-- Group Member -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:335px;grid-gap:50px">
      @foreach($members as $member)
      <div class="card border_radius_12 d-flex flex-column">
        
        <div class="card-body d-flex flex-column justify-content-center align-items-center" style="gap:20px">
          @if($member->members->file)
          <img src="{{asset('/storage/'.$member->members->file)}}" class="img-card" alt="Card image cap" style="min-width:100px;min-height:100px">
          @else
          <img class="img-card" src="{{asset('/storage/icon/user.png')}}" alt="Card image cap" style="min-width:100px;min-height:100px">
          @endif
          <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="inter-bold plain_text">{{$member->members->name}}</div>
            <div class="inter-regular plain_text">{{$member->position}}</div>
          </div>


        </div>


      </div>
      @endforeach

    </div>
  </div>

</div>

<script>
  function sendInvitation() {
    var formData = {
      "email": $("#member_gmail").val(),
      "group_id": $("#group_id").val(),
      "_token": "{{ csrf_token() }}"
    };
    var url = '/{{env("base_url")}}' + 'sendInvitation';

    $.ajax({
      method: 'POST',
      type: 'POST',
      url: url,
      data: formData,
      success: function(data) {

        if (data.status == "success") {
          swal(data.message, "", "success");
        } else {
          swal(data.message, "", "error");
        }

      },
      erros: function(data) {
        swal(data, "", "error");
      }

    });

  }
</script>



@endsection
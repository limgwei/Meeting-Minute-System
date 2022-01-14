@extends('layouts.app')

@section('content')

<form enctype="multipart/form-data" action="{{route('settings.updateProfile')}}" method="POST" class="padding-5 d-flex flex-column">
  @csrf
  <div class="inter-bold header_text">{{ __('setting.my_profile') }}</div>
  <div class="card border_radius_12" style="margin:24px 0 0 0">
    <div class="card-body d-flex justify-content-between" style="gap:20px">
      <div class="d-flex flex-column" style="gap:20px;flex-grow:8">
        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('setting.name') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="name" value="{{$user->name}}" required>
        </div>

        <div class="d-flex flex-column" style="gap:8px">
          <div class="inter-medium plain_text">{{ __('setting.email') }}<span class="text-danger">*</span></div>
          <input type="text" class="form-control input_text" name="email" value="{{$user->email}}" required>
        </div>

        <div class="d-flex flex-row-reverse">
          <button class="btn btn-primary button_text" style="width:fit-content">{{ __('setting.update') }}</button>
        </div>
      </div>

      <div style="position:relative;text-align:center;color:white">
        <div class="d-flex justify-content-center" style="margin-top:5%;margin-bottom:5%;position:relative">
          @if($user->file)
          <img src="{{asset('/storage/'.$user->file)}}" alt="Card image cap" class="hover_button" id="output">
          @else
          <img src="{{asset('/storage/icon/user.png')}}" alt="Card image cap" class="hover_button" id="output">
          @endif
          <label for="image" class="picture_hover">
            <div class="d-flex justify-content-center align-items-center ">
              <i class="bi bi-camera" style="font-size:50px"></i>
            </div>
          </label>

          <input type="file" accept="image/*" style="display: none" id="image" onchange="loadFile(event)" name="file">

        </div>
      </div>
    </div>
  </div>

</form>


<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
@endsection
@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<style>

.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}

  .progress {
    width: 150px;
    height: 150px;
    line-height: 150px;
    background: none;
    margin: 0 auto;
    box-shadow: none;
    position: relative;
  }

  /* .progress:after{
    content: "";
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 12px solid #fff;
    position: absolute;
    top: 0;
    left: 0;
} */
  .progress>span {
    width: 50%;
    height: 100%;
    overflow: hidden;
    position: absolute;
    top: 0;
    z-index: 1;
  }

  /* .progress .progress-left{
    left: 0;
} */
  .progress .progress-bar {
    width: 100%;
    height: 100%;
    background: none;
    border-width: 12px;
    border-style: solid;
    position: absolute;
    top: 0;
  }

  .progress .progress-left .progress-bar {
    left: 100%;
    border-top-right-radius: 80px;
    border-bottom-right-radius: 80px;
    border-left: 0;
    -webkit-transform-origin: center left;
    transform-origin: center left;
  }

  .progress .progress-right {
    right: 0;
  }

  .progress .progress-right .progress-bar {
    left: -100%;
    border-top-left-radius: 80px;
    border-bottom-left-radius: 80px;
    border-right: 0;
    -webkit-transform-origin: center right;
    transform-origin: center right;
    animation: loading-1 1.5s linear forwards;
  }

  .progress .progress-value {
    width: 90%;
    height: 90%;
    border-radius: 50%;
    background: #44484b;
    font-size: 16px;
    color: #fff;
    line-height: 135px;
    text-align: center;
    position: absolute;
    top: 5%;
    left: 5%;
  }

  .progress.blue .progress-bar {
    border-color: #049dff;
  }

  .progress.blue .progress-left .progress-bar {
    animation: loading-2 1.5s linear 1.5s forwards;
  }

  @keyframes loading-1 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(180deg);
      transform: rotate(180deg);
    }
  }

  @keyframes loading-2 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(170deg);
      transform: rotate(178deg);
    }
  }

  @media only screen and (max-width: 990px) {
    .progress {
      margin-bottom: 20px;
    }
  }
</style>
<button id="load" style="display:none">Load It!</button>

<div class="modal js-loading-bar " data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#7c7c7d;border:0px solid grey">
      <div class="modal-body" style="background-color:#7c7c7d;">

        <div class="progress blue">
          <span class="progress-left">
            <span class="progress-bar"></span>
          </span>
          <span class="progress-right">
            <span class="progress-bar"></span>
          </span>
          <div class="progress-value">{{ __('setting.changing_language') }}</div>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="padding-5 d-flex flex-column" style="gap:50px;max-width:300px">

  <h5 class="inter-bold header_text">
    {{ __('setting.setting') }}
  </h5>

  <input type="hidden" value="{{csrf_token()}}" id="token">
  <div><a href="{{route("settings.editProfile")}}" class="header_text inter-regular">{{ __('setting.edit_profile') }}</a></div>
  <select name="" id="language" class="form-control inter-medium " style="box-sizing: content-box;padding:5px;padding-left:20px">
    <option value="en" {{$locale=="en"?'selected':''}}>English</option>
    <option value="cn" {{$locale=="cn"?'selected':''}}>中文</option>
  </select>

  <form action="{{route("logout")}}" method="POST">
    @csrf
    <button class="btn btn-danger button_text">{{__('setting.logout')}}</button>
  </form>

</div>

<script>
  var success = false;
  $("#language").on("change", function() {
    $("#load").click();
    var url = '/{{env("base_url")}}' + 'settings/change-language';

    $.ajax({
      url: url,
      type: "POST",
      data: {
        language: $("#language").val(),
        _token: $("#token").val()
      },
      success: function(response) {
        success = true;
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  var url = '/{{env("base_url")}}' + 'notifications';
  $.ajax({
    type: "GET",
    url: url,
    success: function(data) {
      if (data != 0) {
        $("#notifications").css("visibility", "visible");
        $("#notifications").text(data);
      }
    },
    erros: function(data) {
      console.log(data);
    }
  });
</script>

<script>
  // Setup
  this.$('.js-loading-bar').modal({
    backdrop: 'static',
    show: false
  });

  $('#load').click(function() {
    var $modal = $('.js-loading-bar'),
      $bar = $modal.find('.progress');

    $modal.modal('show');
    $bar.addClass('animate');

    setTimeout(function() {
      if (success == true) {
        location.reload();
      }
      $bar.removeClass('animate');
      $modal.modal('hide');
    }, 3000);
  });
</script>
@endsection
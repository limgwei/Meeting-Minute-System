<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;subset=chinese-simplified">

  <script src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{asset('/storage/js/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/storage/js/printThis.js')}}"></script>
  <script type="text/javascript" src="{{asset('/storage/js/sweetalert.min.js')}}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="{{asset('/storage/css/fonts/nunito.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- sidebar -->
  <link type="text/css" rel="stylesheet" href="{{asset('/storage/css/sidebar.css')}}" />
  <link type="text/css" rel="stylesheet" href="{{asset('/storage/css/custom.css')}}" />

  <script type="text/javascript" src="{{asset('/storage/js/datatables.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/storage/js/basic.js')}}"></script>


  <link rel="stylesheet" href="{{asset('/storage/css/icons/icomoon/styles.min.css')}}">


  <!-- bootstrap -->
  <script src="{{asset('/storage/js/dataTables.bootstrap5.min.js')}}"></script>

  <link rel="stylesheet" href="{{asset('/storage/css/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/storage/css/bootstrap/dataTables.bootstrap5.min.css')}}">
  <link rel="stylesheet" href="{{asset('/storage/css/bootstrap/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('/storage/css/bootstrap/font-awesome.min.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<body>
  <div id="printThis" class="printme padding-5" style="width:595px;height:842px;">
    <div class="d-flex flex-column" style="gap:30px">
      <div class="inter-regular header_text " style="color: #007bff">Meeting Title- Group Name</div>
      <div class="d-flex flex-column" style="gap:30px">

        <div class="inter-bold">I . MEETING DETAILS</div>

        <!-- organiser and secretary -->
        <div>
          <div class="inter-regular d-flex" style="gap:5px">
            <div>Organiser:</div>
            <div style="color: #007bff">中文</div>
          </div>

          <div class="inter-regular d-flex" style="gap:5px">
            <div>Secretary:</div>
            <div style="color: #007bff">John Doe</div>
          </div>
        </div>

        <!-- date and time and venue -->
        <div>
          <div class="inter-regular d-flex" style="gap:5px">
            <div>Date:</div>
            <div style="color: #007bff">November 5,2020</div>
          </div>

          <div class="inter-regular d-flex" style="gap:5px">
            <div>Time:</div>
            <div style="color: #007bff">11.00AM</div>
          </div>

          <div class="inter-regular d-flex" style="gap:5px">
            <div>Venue:</div>
            <div style="color: #007bff">Virtual Meeting</div>
          </div>
        </div>

      </div>

      <div class="d-flex flex-column" style="gap:30px">
        <div class="inter-bold">II . ATTENDEES</div>
        <div style="color: #007bff">Name,Name and Name</div>
      </div>


      <div class="d-flex flex-column" style="gap:30px">
        <div class="inter-bold">III . ABSENCES</div>
        <div>Name,Name and Name</div>
      </div>

      <div class="d-flex flex-column" style="gap:30px">
        <div class="inter-bold">IV . REPORTS</div>
        <div>Name,Name and Name</div>
      </div>
    </div>
  </div>

</body>

</html>
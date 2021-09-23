<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;subset=chinese-simplified">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <style>
    body {
      font-family: 'Noto Sans SC', sans-serif;
    }
  </style>
</head>

<body>
  <div id="printThis" class="printme">

    <div>
      <h1>Meeting:{{$meeting->title}}</h1>
      <p>Organiser:{{$meeting->organiser->name}}</p>
      <p>Secretary:{{$meeting->secretary->name}}</p>
      <p>Date:{{$date_text}}</p>
      <p>Time:{{$time_text}}</p>
      <p>Venue:{{$meeting->venue}}</p>

      <div>
        <div>Attendance</div>
        <div class="d-flex">
          <div>Present:</div>
          <div>
            @foreach($attends as $attend)
            <div>{{$attend->users->name}},{{$attend->position}}</div>
            @endforeach
          </div>
        </div>
        <div class="d-flex">
          <div>Absent :</div>
          <div>
            @foreach($absents as $absent)
            <div>{{$absent->users->name}},{{$absent->position}}</div>
            @endforeach
          </div>
        </div>
      </div>


    </div>
    @php
    $countTitle = 0;
    @endphp

    @foreach($titles as $title)
    @php
    $countTitle++;
    @endphp

    <div style="padding-left:5%">
      <div>
        <h2> {{$countTitle}}.{{$title->title}}</h2>
      </div>
      <div>
        @php
        $countAgenda = 0;
        @endphp

        @foreach($title->agendas as $agenda)
        @php
        $countAgenda++;
        @endphp

        <div style="padding-left:5%">
          <div>
            <h3> {{$countTitle}}.{{$countAgenda}}.{{$agenda->title}}</h3>
          </div>
          <div>
            {{$agenda->description}}
          </div>
          <div>

            @php
            $countKeypoint = 0;
            @endphp

            @foreach($agenda->keypoints as $keypoint)

            @php
            $countKeypoint++;
            @endphp
            @if( $keypoint!="")
            <div style="padding-left:5%">
              {{$countTitle}}.{{$countAgenda}}.{{$countKeypoint}}.{{$keypoint}}
            </div>
            @endif

            @endforeach

            @if($agenda->action_taken)
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Action taken:</label>
              <div class="col-lg-6">
                <label class="col-lg-6 col-form-label">{{$agenda->action_taken}}</label>
              </div>
            </div>  
            @endif
            @if($agenda->action_user)
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Taken by:</label>
              <div class="col-lg-6">
                <label class="col-lg-6 col-form-label">{{$agenda->action_user->name}}</label>
              </div>
            </div>  
            @endif

  
      </div>
       
       
    </div>
    @endforeach
  </div>
</div>
@endforeach
</div>

</body>
</html>
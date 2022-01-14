<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+SC&amp;subset=chinese-simplified">


  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@1,900&display=swap" rel="stylesheet">

</head>

<body>
  <style>
    body {
      font-family: 'Work Sans', sans-serif;
    }

    *{
      font-size:1em;
    }
  </style>
  <div id="printThis" class="printme">
    <div style="gap:30px;display:flex;flex-direction:column;margin-bottom:30px">
      <div class="inter-regular " style="color: #007bff;font-size:20px;margin-bottom:30px;text-align:center">{{$meeting->title}}- {{$group->title}}</div>
      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">

        <div style="margin-bottom:30px;"> <b>I . MEETING DETAILS</b> </div>

        <!-- organiser and secretary -->
        <div style="margin-bottom:30px">
          <div class="inter-regular d-flex">
            <div>Organiser: <span style="color: #007bff">{{$meeting->organiser->name}}</span></div>
          </div>

          <div class="inter-regular">
            <div>Secretary: <span style="color: #007bff">{{$meeting->secretary->name}}</span></div>
          </div>
        </div>

        <!-- date and time and venue -->
        <div>
          <div class="inter-regular ">
            <div>Date: <span style="color: #007bff">{{$date_text}}</span></div>
          </div>

          <div class="inter-regular">
            <div>Time: <span style="color: #007bff">{{$time_text}}</span></div>
          </div>

          <div class="inter-regular">
            <div>Venue: <span style="color: #007bff">{{$meeting->venue}}</span></div>
          </div>
        </div>

      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b>II . ATTENDEES</b></div>
        <div style="color: #007bff">
          @foreach($attends as $attend)
          {{$attend->users->name}},
          @endforeach
        </div>
      </div>


      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b> III . ABSENCES</b></div>
        <div style="color: #007bff">
          @foreach($absents as $absent)
          {{$absent->users->name}},
          @endforeach
        </div>
      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b>IV . AGENDAS</b> </div>
        <div>

          @foreach($titles as $title)

          <div style="padding-left:5%">
            <div>
              <div> {{$title->title}}</div>
            </div>
            <div>

              @foreach($title->agendas as $agenda)

              <div style="padding-left:5%">
                <div>
                  <div> {{$agenda->title}}</div>
                </div>
                <div>
                  {{$agenda->description}}
                </div>
                <div>
                  {!! html_entity_decode($agenda->keypoints) !!}

                  @if($agenda->action_taken)

                  <div class="inter-regular d-flex" style="gap:5px">
                    <div>Action taken: <span style="color: #007bff">{{$agenda->action_taken}}</span></div>
                  </div>
                  @endif
                  @if($agenda->action_user)
                  <div class="inter-regular d-flex" style="gap:5px">
                    <div>Taken by: <span style="color: #007bff">{{$agenda->action_user->name}}</span></div>
                    
                  </div>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>


  </div>

</body>

</html>
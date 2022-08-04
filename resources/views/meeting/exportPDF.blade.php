<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
 

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
      <div class="inter-regular " style="color: #007bff;font-size:30px;margin-bottom:30px;text-align:center">{{$meeting->title}}- {{$group->title}}</div>
      <div class="d-flex flex-column" style="margin-bottom:30px">

        <div style="margin-bottom:30px;font-size:20px;"> <b >I . MEETING DETAILS</b> </div>

        <!-- organiser and secretary -->
        <div style="margin-bottom:30px">
          <div class="inter-regular d-flex">
            <div><span style="font-size:18px">Organiser:</span>  <span style="color: #007bff">{{$meeting->organiser->name}}</span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Secretary:</span> <span style="color: #007bff">{{$meeting->secretary->name}}</span></div>
          </div>
        </div>

        <!-- date and time and venue -->
        <div>
          <div class="inter-regular ">
            <div><span style="font-size:18px">Date:</span> <span style="color: #007bff">{{$date_text}}</span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Time:</span> <span style="color: #007bff">{{$time_text}}</span></div>
          </div>

          <div class="inter-regular">
            <div><span style="font-size:18px">Venue:</span><span style="color: #007bff">{{$meeting->venue}}</span></div>
          </div>
        </div>

      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b style="font-size:20px;">II . ATTENDEES</b></div>
        <div style="color: #007bff">
          @foreach($attends as $attend)
          {{$attend->users->name}},
          @endforeach
        </div>
      </div>


      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold"><b style="font-size:20px;"> III . ABSENCES</b></div>
        <div style="color: #007bff">
          @foreach($absents as $absent)
          {{$absent->users->name}},
          @endforeach
        </div>
      </div>

      <div class="d-flex flex-column" style="gap:30px;margin-bottom:30px">
        <div class="inter-bold" style="margin-bottom:30px"><b style="font-size:20px;">IV . AGENDAS</b> </div>
        <div>

          @foreach($titles as $title)

          <div style="padding-left:5%;margin-bottom:30px">
            <div>
              <div style="font-size:18px"> {{$title->title}}</div>
            </div>
            <div>

              @foreach($title->agendas as $agenda)

              <div style="padding-left:5%;margin-top:40px">
                <div>
                  <b> {{$agenda->title}}</b>
                </div>
                <div>
                  {{$agenda->description}}
                </div>
                <div style="margin-top:20px">
                  <b>Keypoints</b>
                  {!! html_entity_decode($agenda->keypoints) !!}

                  @if($agenda->action_taken)

                  <div class="inter-regular d-flex" style="margin-top:20px">
                    <div><b>Action taken:</b>  <span style="color: #007bff">{{$agenda->action_taken}}</span></div>
                  </div>
                  @endif
                  @if($agenda->action_user)
                  <div class="inter-regular d-flex" style="margin-top:20px">
                    <div><b>Taken by:</b><span style="color: #007bff">{{$agenda->action_user->name}}</span></div>
                    
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
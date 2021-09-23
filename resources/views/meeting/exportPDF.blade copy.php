@extends('layouts.app')

@section('content')

<!-- <style>
  .printme{
    displa
  }
</style> -->

<div id="printThis" class="printme">

  <div>
    <h1>Meeting:{{$meeting->title}}</h1>
    <p>Date:{{$meeting->date}}</p>
    <p>Time:{{$meeting->time}}</p>
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

          <div style="padding-left:5%">
            {{$countTitle}}.{{$countAgenda}}.{{$countKeypoint}}.{{$keypoint}}
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach
</div>

<script>
  window.print();
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div style="width:100%">
    @include('layouts.meetingNav') 
      <!-- Meeting minutes -->
      @foreach($meetings as $meeting)
      <a href="{{route("meetings.show",$meeting->id)}}" style="color:black;text-decoration:none">
        <div class="card"">
          <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
          <div class="card-body">
            <h5>{{$meeting->title}}</h5>
            <div>{{$meeting->date}}</div>
            <div>{{$meeting->time}}</div>
            <div>{{$meeting->venue}}</div>
          </div>

        </div>
      </a>
      @endforeach



    </div>
  </div>
</div>

@endsection
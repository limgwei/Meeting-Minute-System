@extends('layouts.app')

@section('content')
<style>
  .date{
    background-color: orange;
    border-radius: 25px / 17px;
    left: -20px;
    border-width: 17px 17px 17px 0;
    width:max-content;padding:7px;
    height:max-content;
  }

  .time{
    height:max-content;
    background-color:  #28a745;
    border-radius: 25px / 17px;
    left: -20px;
    border-width: 17px 17px 17px 0;
    width:max-content;padding:7px;
    color:white;
  }

  .count{
    background-color:#dc3545;
    line-height: 25px;
    border-radius:25px;
    width:25px!important;
    padding:5px;
    height:25px!important;
    color:white;
  }
</style>
<div>
  @include('layouts.meetingNav')
  <div class="padding-5">
    <h5 class="inter-bold header_text">{{ __('layout.meeting_schedule') }}</h5>
    <div class="card border_radius_12">
      <div class="card-body  ">

        <div class="d-flex justify-content-around">
          <div class="d-flex flex-column align-items-center">
            <div class="d-flex" style="gap:20px">
            <div class="inter-bold">{{ __('group.pending') }} <span class="count">{{$pending_meetings->count}}</span></div>
            </div>
         
            @foreach($pending_meetings as $meeting)
            <div class="card border_radius_12" style="min-width:300px">
              <!-- <img class=" card-img-top" src="..." alt="Card image cap"> -->
              <div class="card-body d-flex flex-column" style="gap:10px">
                <div class="font-bold">{{$meeting->title}}</div>

                  <div class="d-flex" style="gap:12px">
                    
                    <div class="font-small date" >{{$meeting->local_date}}</div>
                    <div class="font-small time" >{{$meeting->local_time}}</div>
                  </div>
               
                <!-- location -->
                <div class="d-flex align-items-center" style="gap:25px">
                  <div><img  src="{{asset('/storage/icon/geo-alt.svg')}}"></div>
                  <div class="d-flex flex-column" style="gap:0">
                    <div class="font-small">{{ __('group.location') }}</div>
                    <div class="font-bold">{{$meeting->venue}}</div>
                  </div>
                </div>

                <div class="d-flex flex-row-reverse" style="gap:25px">
                  <a href="{{route("meetings.show",$meeting->id)}}"><i class="bi bi-book" style='font-size:32px;'></i>
                  </a>
                  @if($group_user_id == Auth::user()->id)
                  <a href="{{route("meetings.edit",$meeting->id)}}"> <i class="bi bi-pencil-square " style='font-size:32px;'></i></a>
                  @endif
                </div>




              </div>
            </div>
            @endforeach
          </div>

          <div>

          </div>
          <div class="d-flex flex-column align-items-center">
          <div class="d-flex" style="gap:20px">
            <div class="inter-bold">{{ __('group.pass') }} <span class="count">{{$pass_meetings->count}}</span></div>
            </div>
            @foreach($pass_meetings as $meeting)
            <div class="card border_radius_12" style="min-width:300px">
              <!-- <img class=" card-img-top" src="..." alt="Card image cap"> -->
              <div class="card-body d-flex flex-column" style="gap:10px">
                <div class="font-bold">{{$meeting->title}}</div>

                  <div class="d-flex" style="gap:12px">
                    
                    <div class="font-small date" style="width:max-content;padding:5px">{{$meeting->local_date}}</div>
                    <div class="font-small time" style="width:fit-content">{{$meeting->local_time}}</div>
                  </div>
               
                <!-- location -->
                <div class="d-flex align-items-center" style="gap:25px">
                  <div><img src="{{asset('/storage/icon/geo-alt.svg')}}"></div>
                  <div class="d-flex flex-column" style="gap:0">
                    <div class="font-small">{{ __('group.location') }}</div>
                    <div class="font-bold">{{$meeting->venue}}</div>
                  </div>
                </div>

                <div class="d-flex flex-row-reverse" style="gap:25px">
                  <a href="{{route("meetings.show",$meeting->id)}}"><i class="bi bi-book" style='font-size:32px;'></i>
                  </a>
                  @if($group_user_id == Auth::user()->id)
                  <a href="{{route("meetings.edit",$meeting->id)}}"> <i class="bi bi-pencil-square " style='font-size:32px;'></i></a>
                  @endif
                </div>




              </div>
            </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
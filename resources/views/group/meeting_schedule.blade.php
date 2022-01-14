@extends('layouts.app')

@section('content')
<!-- Add the evo-calendar.css for styling -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css" />

<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for.. obviously, functionality! -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<link rel="stylesheet" type="text/css" href="{{asset('/storage/evo/demo/demo.css')}}">

<section id="demos">
  <div class="section-content">

    <div class="log-content">
      <div class="--noshadow" id="demoEvoCalendar"></div>
    </div>

  </div>
</section>


<script>
  var calendar = $("#demoEvoCalendar").evoCalendar({
    sidebarDisplayDefault: false,
    sidebarToggler: true,
    eventListToggler: true,
    eventListDisplayDefault: true,
  });
  $(document).ready(function() {
    var url = '/{{env("base_url")}}' + 'groups/meeting_schedule_action';
    $.ajax({
      type: "GET",
      url: url,
      success: function(data) {
        calendar.evoCalendar('addCalendarEvent',data);
      },
      erros: function(data) {

      }
    });
  });

  calendar.on('selectEvent',function(event,activeEvent){
    console.log(event);
    console.log(activeEvent.id);
    var url = '/{{env("base_url")}}' + 'meetings/view/'+activeEvent.id;

    window.location.href = url;

  });

  // $("#demoEvoCalendar").evoCalendar({
  //   sidebarDisplayDefault: false,
  //   sidebarToggler: true,
  //   eventListToggler: true,
  //   eventListDisplayDefault: true,
  //   calendarEvents: [{
  //       id: '1', // Event's ID (required)
  //       name: "User 1", // Event name (required)
  //       date: "2021-11-01", // Event date (required)
  //       description: "Nasi Lemak(1 person), rice(small)x1",
  //       type: "holiday", // Event type (required)
  //     },
  //     {
  //       id: '2', // Event's ID (required)
  //       name: "User 2", // Event name (required)
  //       date: "December/1/2021", // Event date (required)
  //       description: "Nasi Lemak(1 person), rice(small)x1",
  //       type: "holiday", // Event type (required)
  //     },
  //     {
  //       id: '3', // Event's ID (required)
  //       name: "User 3", // Event name (required)
  //       date: "December/1/2021", // Event date (required)
  //       description: "Nasi Lemak(1 person), rice(small)x1",
  //       type: "holiday", // Event type (required)
  //     },
  //     // {
  //     //   id: '2',
  //     //   name: "Vacation Leave",
  //     //   badge: "02/13 - 02/15", // Event badge (optional)
  //     //   date: ["February/13/2020", "February/15/2020"], // Date range
  //     //   description: "Vacation leave for 3 days.", // Event description (optional)
  //     //   type: "event",
  //     //   color: "#63d867" // Event custom color (optional)
  //     // }, {
  //     //   id: '3', // Event's ID (required)
  //     //   name: "New Year", // Event name (required)
  //     //   date: "February/13/2020", // Event date (required)
  //     //   type: "holiday", // Event type (required)
  //     //   everyYear: true // Same event every year (optional)
  //     // }
  //   ]
  // });

  $("#sidebarToggler").on("click", function() {
    $('#demoEvoCalendar').addClass('event-hide')
  });

  $("#eventListToggler").on("click", function() {
    $('#demoEvoCalendar').addClass('sidebar-hide')
  });
</script>
@endsection
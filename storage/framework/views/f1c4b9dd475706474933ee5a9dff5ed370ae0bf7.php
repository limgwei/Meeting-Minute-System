

<?php $__env->startSection('content'); ?>
<!-- Add the evo-calendar.css for styling -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css" />

<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for.. obviously, functionality! -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<style>
  .calendar-table{
    color:black!important;
  }
  th[colspan="7"]{
    color:black!important;
  }

  .event-empty {
    background-color:white!important;
    border:1px solid white!important;
    border-radius: 12px;
    box-shadow: 5px 0 18px -3px rgb(0 0 0 / 15%)!important;
  }

  .event-container>.event-info>p.event-title>span {
    
    color:  #007bff;
    border: 1px solid #007bff;
    background-color: white;
}

  .event-empty p{
   color:#007bff!important;
  
  }
  .event-list{
    background-color:white!important;
  }
  .calendar-sidebar{
    background-color:white!important;
    box-shadow: 5px 0 18px -3px rgb(0 0 0 / 15%)!important;
    border: 1px solid #f7f8fa;
  }
  .calendar-year{
    color:black!important;
  }

.calendar-sidebar>.calendar-year>button.icon-button>span{
  border-right: 4px solid black;
    border-bottom: 4px solid black;
}

  .month{
    color:black!important;
  }

  .active-month{
    background-color:white!important;
    color:#007bff!important;
  }
  .month:hover{
    background-color:white!important;
    color:#007bff!important;
  }
  #demoEvoCalendar{
    box-shadow: 0 10px 50px -20px white;
  }

  .event-container{
    box-shadow: 0 10px 50px -20px rgb(0 0 0 / 15%);
  }
  #eventListToggler {
  
    background-color:#007bff!important;
    box-shadow: 5px 0 18px -3px rgb(0 0 0 / 15%)!important;
  }

  #sidebarToggler {
    background-color:#007bff!important;
    box-shadow: 5px 0 18px -3px rgb(0 0 0 / 15%)!important;
  }
</style>

<section id="demos" class="card" style="border-radius:12px">
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
    var url = '/<?php echo e(env("base_url")); ?>' + 'groups/meeting_schedule_action';
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
    var url = '/<?php echo e(env("base_url")); ?>' + 'meetings/view/'+activeEvent.id;

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\minut\resources\views/group/meeting_schedule.blade.php ENDPATH**/ ?>
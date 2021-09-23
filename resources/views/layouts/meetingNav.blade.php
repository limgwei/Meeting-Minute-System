

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route("groups.show",$group_id)}}" style="color:{{Route::is('groups.show')?'blue':'black'}}">Current Schedule</a>
  <a class="navbar-brand" href="{{route("pending_agendas.index",$group_id)}}" style="color:{{Route::is('pending_agendas.index')?'blue':'black'}}">Pending Agenda</a>
  <a class="navbar-brand" href="{{route("groups.members",$group_id)}}" style="color:{{Route::is('groups.members')?'blue':'black'}}">Member</a>
</nav>
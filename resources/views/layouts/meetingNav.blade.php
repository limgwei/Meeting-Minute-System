

<div class="navbar navbar-expand-lg navbar-ligh d-flex justify-content-around" style="border:1px solid #e8e8e8;background:white" >
  <a class="navbar-brand inter-regular" href="{{route("groups.show",$group_id)}}" style="color:{{Route::is('groups.show')?'#007bff':'black'}}">{{ __('layout.schedule') }}</a>
  <a class="navbar-brand inter-regular" href="{{route("pending_agendas.index",$group_id)}}" style="color:{{Route::is('pending_agendas.index')?'#007bff':'black'}}">{{ __('layout.pending_agenda') }}</a>
  <a class="navbar-brand inter-regular" href="{{route("groups.members",$group_id)}}" style="color:{{Route::is('groups.members')?'#007bff':'black'}}">{{ __('layout.member') }}</a>
</div>
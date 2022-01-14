@extends('layouts.app')

@section('content')

<div class="padding-5 bg d-flex flex-column" style="gap:30px">
  <div class="d-flex justify-content-between">

    <input type="text" class="form-control input_text" style="max-width:200px" placeholder="Search..">

    <div>
      <button class="btn btn-primary button_text" data-toggle="modal" data-target="#addNewGroup">{{ __('group.add_group') }}</button>
      <button class="btn btn-default button_text" data-toggle="modal" data-target="#joinGroup">{{ __('group.join_group') }}</button>
    </div>
  </div>
  <div class="inter-bold header_text">{{ __('group.groups') }}</div>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:335px;grid-gap:50px">
    @foreach($groups as $group)


    <div class="card border_radius_12 d-flex flex-column" style="margin:0">

      <div class="card-body d-flex flex-column justify-content-around">

        <div class="d-flex flex-column align-items-center">
          @if($group->user_id == Auth::user()->id)
          <div class="d-flex flex-column-reverse" style="width:100%">
            <a href="{{route('groups.edit',$group->id)}}" style="text-align:right;"><i class="bi bi-pencil-square" style='font-size:20px;'></i></a>
          </div>
          @endif

          @if($group->file)
          <img src="{{asset('/storage/'.$group->file)}}" class="img-card" alt="Card image cap" style="width:150px;height:150px">
          @else
          <img class="img-card" src="{{asset('/storage/icon/group.jpg')}}" alt="Card image cap" style="width:150px;height:150px">
          @endif


        </div>
        <div class="d-flex justify-content-center flex-column align-items-center">
          <div class="inter-bold">{{$group->title}}</div>
          <a href="{{route('groups.show',$group->id)}}" class="join-btn " style="line-height: 50px;width:100%;">{{ __('group.view') }}</a>
        </div>

      </div>


    </div>
    @endforeach
  </div>




  <div id="addNewGroup" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><span class="font-weight-bold">{{ __('group.add_group') }}</span></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{route('groups.store')}}" method="POST">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label"><span class="text-danger">*</span class="plain_text">{{ __('group.title') }}:</label>
              <div class="col-lg-9">
                <input type="text" class="form-control input_text" name="title" placeholder="{{ __('group.title') }}" required>
              </div>
            </div>
            @csrf
            <div class="text-right">
              <button type="submit" class="btn btn-primary button_text">
                SAVE
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="joinGroup" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><span class="font-weight-bold">{{ __('group.join_group') }}</span></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{route("groups.joinGroup")}}" method="POST">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label"><span class="text-danger">*</span class="plain_text">{{ __('group.code') }}:</label>
              <div class="col-lg-9">
                <input type="text" class="form-control input_text" name="code" required>
              </div>
            </div>
            @csrf
            <div class="text-right">
              <button type="submit" class="btn btn-primary button_text">
                {{ __('group.join') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
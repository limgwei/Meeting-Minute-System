@extends('layouts.app')

@section('content')
<script src="{{ asset('js/change_group.js') }}"></script>
<div class="container">
  <div class="row justify-content-center">
    <div class="d-flex flex-column" style="width:100%">
      <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
          <div class="page-title d-flex">
            <h4>
              <span class="font-weight-bold mr-2">Editing</span>
              <i class="icon-circle-right2 mr-2"></i>
              <span class="font-weight-bold mr-2">Pending Agenda</span>
            </h4>
          </div>
        </div>
      </div>

      <div class="content">
        <div>
          <div class="card">
            <div class="card-body">
              <form enctype="multipart/form-data" action="{{route('pending_agendas.update')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-address-book mr-2"></i>
                </legend>
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Title:</label>
                  <div class="col-lg-9">
                    <input value="{{$pending_agenda->title}}" type="text" class="form-control form-control-lg" name="title" placeholder="Title" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Description:</label>
                  <div class="col-lg-9">
                    <input value="{{$pending_agenda->description}}" type="text" class="form-control form-control-lg" name="description" placeholder="Description" >
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Attachment File:</label>
                 
                  <div class="col-lg-9">
                  <a href="{{asset('/storage/'.$pending_agenda->file)}}" download>{{$pending_agenda->filename}}</a>
                    <input value="" type="file" class="form-control form-control-lg" name="file" accept=".pdf">
                  </div>
                </div>
                
                <div class="text-right" style="float:right">
                  <button type="submit" class="btn btn-primary">
                    Update
                    <i class="icon-database-insert ml-1"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
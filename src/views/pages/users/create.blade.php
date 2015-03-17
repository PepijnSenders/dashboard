@extends('dashboard::layouts.default')

@section('dashboard::title')
Create
@stop

@section('dashboard::content')
<legend>
  <h1>Create a new dashboard user.</h1>
</legend>

@if (isset($messages))
  @foreach ($messages as $message)
  <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif

<form class="form-horizontal" method="POST" action="{{ URL::route('dashboard::api.users.create') }}">
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="email">Email</label>
    <div class="col-sm-8">
      <input type="email" name="email" class="form-control" id="email">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="name">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="name">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="rights">Rights</label>
    <div class="col-sm-8">
      <label for="create">
        <input type="checkbox" name="rights[]" id="create" value="create">
        Admin
      </label>
      @foreach ($models as $key => $model)
      <label for="{{ $key }}">
        <input checked="checked" type="checkbox" name="rights[]" id="{{ $key }}" value="{{ $key }}">
        {{ Str::title($key) }}
      </label>
      @endforeach
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Submit</button>
  </div>
</form>
@stop
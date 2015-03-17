@extends('dashboard::layouts.default')

@section('dashboard::title')
Edit
@stop

@section('dashboard::content')
<legend>
  <h1>Edit a dashboard user.</h1>
</legend>

@if (isset($messages))
  @foreach ($messages as $message)
  <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif

<form class="form-horizontal" method="POST" action="{{ URL::route('dashboard::api.users.edit') }}">
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <input type="hidden" name="id" value="{{ $user->_id }}">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="email">Email</label>
    <div class="col-sm-8">
      <input type="email" value="{{ $user->email }}" name="email" class="form-control" id="email">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="name">Name</label>
    <div class="col-sm-8">
      <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="password">New password (leave blank if not changing)</label>
    <div class="col-sm-8">
      <input type="text" name="password" class="form-control" id="password">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="rights">Rights</label>
    <div class="col-sm-8">
      <label for="create">
        <input type="checkbox"
          @if (in_array('create', $user->rights))
          checked="checked"
          @endif
         name="rights[]" id="create" value="create">
        Admin
      </label>
      @foreach (Config::get('dashboard.models') as $key => $model)
      <label for="{{ $key }}">
        <input
        @if (in_array($key, $user->rights))
        checked="checked"
        @endif
        type="checkbox" name="rights[]" id="{{ $key }}" value="{{ $key }}">
        {{ Str::title($key) }}
      </label>
      @endforeach
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Save</button>
  </div>
</form>
@stop
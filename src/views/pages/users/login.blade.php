@extends('dashboard::layouts.default')

@section('dashboard::title')
Login
@stop

@section('dashboard::content')
<legend>
  <h1>Welcome, to the {{ Config::get('dashboard::dashboard.title') }}.</h1>
  <p>Please login to gain entry</p>
</legend>

@if (isset($messages))
  @foreach ($messages as $message)
  <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif
<form class="form-horizontal" method="POST" action="{{ URL::route('dashboard::api.login') }}">
  @if (isset($url) && $url)
    <input type="hidden" name="url" value="{{ $url }}">
  @endif
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="email">
      Email:
    </label>
    <div class="col-sm-8">
      <input id="email" name="email" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="password">
      Password:
    </label>
    <div class="col-sm-8">
      <input id="password" name="password" type="password" class="form-control">
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Submit</button>
  </div>
</form>
@stop

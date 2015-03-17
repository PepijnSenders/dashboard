@extends('dashboard::layouts.default')

@section('dashboard::title')
Export
@stop

@section('dashboard::content')
<legend>
  <h1>Export a collection.</h1>
</legend>

@if (isset($messages))
  @foreach ($messages as $message)
  <p class="text-danger">{{ $message[0] }}</p>
  @endforeach
@endif

<form class="form-horizontal" method="POST" action="{{ URL::route('dashboard::api.export') }}">
  <input type="hidden" name="_token" value="{{ csrf_token(); }}">
  <div>
    <input type="hidden" name="slug" value="{{ Route::input('slug') }}">
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="fields">Fields</label>
    <div class="col-sm-8">
      @foreach ($model['fields'] as $field)
      <label for="{{ $field }}">
        <input checked="checked" type="checkbox" name="fields[]" id="{{ $field }}" value="{{ $field }}">
        {{ Str::title($field) }}
      </label>
      @endforeach
    </div>
  </div>
  <div class="form-group col-sm-2">
    <button class="btn btn-default pull-right" type="submit">Download</button>
  </div>
</form>
@stop
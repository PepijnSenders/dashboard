@extends('dashboard::layouts.default')

@section('dashboard::title')
{{{ Str::title(Route::input('slug')) }}}
@stop

@section('dashboard::content')
<table class="table table-striped">
  <thead>
    <tr>
      <th>
        Key
      </th>
      <th>
        Value
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($stats as $key => $stat)
    <tr>
      <td>{{{ Str::title($key) }}}</td>
      <td>{{{ $stat }}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop
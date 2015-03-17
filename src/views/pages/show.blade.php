@extends('dashboard::layouts.default')

@section('dashboard::title')
{{ Str::title(Route::input('slug')) }}
@stop

@section('dashboard::content')
@if (array_key_exists('filters', $model))
  <form class="form-horizontal filters" action="{{ Request::url() }}" method="GET">
  @foreach ($model['filters'] as $filter => $values)
    <div class="form-group">
      <label for="{{ $filter }}" class="col-sm-2 control-label">{{ Str::title($filter) }}</label>
      <div class="col-sm-10">
        @foreach ($values as $value)
          <label for="{{ $value }}">
            <input
              @if (isset($filters) && array_key_exists($filter, $filters) && in_array($value, $filters[$filter]))
              checked="checked"
              @endif
              type="checkbox" value="{{ $value }}" id="{{ $value }}" name="{{ $filter }}[]">
            {{ $value }}
          </label>
        @endforeach
      </div>
    </div>
  @endforeach
    <div class="form-group col-sm-2">
      <button type="submit" class="btn btn-default">Apply</button>
    </div>
  </form>
@endif
<table class="table table-striped">
  <thead>
    <tr>
      @foreach ($keys as $key)
      <th>{{ Str::title($key) }}</th>
      @endforeach
      @if (array_key_exists('actions', $model))
      <th>Actions</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $record)
      <tr>
        @foreach ($keys as $key)
          @if (array_key_exists($key, $record->getMutatedArray()))
            @define $value = $record->{$key};
            @if (filter_var($value, FILTER_VALIDATE_URL))
              @define $ext = pathinfo($value, PATHINFO_EXTENSION);
              @if (preg_match('/png|jpg|jpeg|bmp|gif/', $ext))
              <td>
                <img src="{{ $value }}" width="150">
              </td>
              @else
              <td>
                <a target="_blank" href="{{ $value }}">Link</a>
              </td>
              @endif
            @elseif (is_bool($value))
            <td>{{ var_export($value, true) }}</td>
            @else
            <td>{{ $value }}</td>
            @endif
          @else
            <td></td>
          @endif
        @endforeach
        @if (array_key_exists('actions', $model))
          @foreach ($model['actions'] as $action)
            <td>@include("dashboard.partials.actions.$action", ['id' => $record->_id, 'slug' => $slug])</td>
          @endforeach
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
{{ $data->links() }}
@stop
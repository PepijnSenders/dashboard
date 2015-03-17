@extends('dashboard::layouts.default')

@section('dashboard::title')
Users
@stop

@section('dashboard::content')
<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Rights</th>
      <th>Created_At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ json_encode($user->rights) }}</td>
      <td>{{ $user->created_at }}</td>
      <td>
          <a href="{{ URL::route('dashboard::pages.users.edit', ['id' => $user->_id]) }}" class="btn btn-warning">Edit</a>
        @if (Auth::pep__dashboard()->user()->_id !== $user->_id)
          <form style="display: inline-block;" action="{{ URL::route('dashboard::api.users.delete', ['id' => $user->_id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token(); }}">
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop
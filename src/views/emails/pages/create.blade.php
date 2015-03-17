@extends('dashboard::emails.layouts.basic')

@section('dashboard::content')
<h1>You've been added to the {{ Config::get('dashboard::dashboard.title') }}</h1>

<p>
  {{ $currentUser->name }} added you to the dashboard. Please login with the following credentials:<br />
  Email: {{ $user->email }}<br />
  Password: {{ $password }}
</p>

<p>
  Out of security reasons your password is not changeable, please take good care of it.
</p>

<p>
  Visit <a href="{{ URL::route('dashboard::pages.home') }}">{{ URL::route('dashboard::pages.home') }}</a> for the dashboard.
</p>

<p>
  Cheers,<br />
  {{ $currentUser->name }}
</p>
@stop
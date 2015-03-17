<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <title>Honor Dashboard &mdash; @yield('dashboard::title')</title>

  <base href="{{ URL::to('/') }}/" />

  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="csrf" content="{{ csrf_token(); }}">

  @include('partials.favicon')

  <link rel="stylesheet" type="text/css" href="css/dashboard/dashboard.css" />

  @yield('dashboard::header.styles')
  @yield('dashboard::header.scripts')
</head>
<body>

  @if (Auth::pep__dashboard()->check())
  @include('dashboard::partials.header')
  @endif

  <section class="container">
    @yield('dashboard::content')
  </section>

  @if (Agent::browser() === 'IE' && $version <= 8)
  <script type="text/javascript" src="dist/libs-legacy.bundle.js"></script>
  @else
  <script type="text/javascript" src="dist/libs.bundle.js"></script>
  @endif

  <script type="text/javascript" src="dist/dashboard.bundle.js"></script>
  @yield('dashboard::footer.scripts')
</body>
</html>
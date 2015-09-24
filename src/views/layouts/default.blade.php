<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <title>{{{ Config::get('dashboard::dashboard.title') }}} &mdash; @yield('dashboard::title')</title>

  <base href="{{{ URL::to('/') }}}/" />

  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="csrf" content="{{{ csrf_token(); }}}">

  @include('partials.favicon')

  <link rel="stylesheet" type="text/css" href="{{{ asset('packages/pep/dashboard/vendor/bootstrap.css') }}}">
  <link rel="stylesheet" type="text/css" href="{{{ asset('packages/pep/dashboard/css/dashboard.css') }}}">

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

  <script type="text/javascript" src="{{{ asset('packages/pep/dashboard/vendor/jquery.js') }}}"></script>
  <script type="text/javascript" src="{{{ asset('packages/pep/dashboard/vendor/bootstrap.js') }}}"></script>

  @yield('dashboard::footer.scripts')
</body>
</html>
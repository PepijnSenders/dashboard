<?php use Pep\Dashboard\Models\User\DashboardUser; ?>
<header class="navbar navbar-inverse navbar-fixed-top" id="dashboard-header">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::route('dashboard::pages.show', ['slug' => array_keys($models)[0]]) }}">
        <img class="header__brand-image" src="{{ Config::get('dashboard::dashboard.logo') }}" alt="{{ Config::get('dashboard::dashboard.title') }}" width="114" />
      </a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        @foreach ($models as $slug => $model)
          <li class="dropdown
            @if (Route::input('slug') === $slug)
            active
            @endif
          ">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $model['name'] }} <span class="caret"></span></a>
            <ul class="dropdown-menu inverse-dropdown" role="menu">
              <li>
                <a href="{{ URL::route('dashboard::pages.show', ['slug' => $slug]) }}">List</a>
              </li>
              <li>
                <a href="{{ URL::route('dashboard::pages.stats', ['slug' => $slug]) }}">Stats</a>
              </li>
              <li>
                <a href="{{ URL::route('dashboard::pages.export', ['slug' => $slug]) }}">Export</a>
              </li>
            </ul>
          </li>
        @endforeach
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::pep__dashboard()->user()->hasRightTo(DashboardUser::CREATE))
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Users <span class="caret"></span>
          </a>
          <ul class="dropdown-menu inverse-dropdown" role="menu">
            <li>
              <a href="{{ URL::route('dashboard::pages.create') }}">Add</a>
            </li>
            <li>
              <a href="{{ URL::route('dashboard::pages.users') }}">List</a>
            </li>
          </ul>
        </li>
        @endif
        <li>
          <a href="{{ URL::route('dashboard::api.logout') }}">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</header>
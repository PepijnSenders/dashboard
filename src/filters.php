<?php

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Pep\Dashboard\User\DashboardUser;

App::before(function() {

  Config::set('auth.multi.pep__dashboard', [
    'driver' => 'eloquent',
    'model' => 'Pep\\Dashboard\\Models\\User\\DashboardUser',
  ]);

});

Route::filter('dashboard__dashboard', function() {
  if (!Auth::pep__dashboard()->check()) {
    return Redirect::route('dashboard::pages.login', ['url' => Request::path()]);
  }
});

Route::filter('dashboard__slug', function($route) {
  $slug = $route->getParameter('slug');
  if (!Auth::pep__dashboard()->user()->hasRightTo($slug)) {
    throw new AccessDeniedException("User has no right to $slug.");
  }
});

Route::filter('dashboard__slug.input', function($route) {
  $slug = Input::get('slug');
  if (!Auth::pep__dashboard()->user()->hasRightTo($slug)) {
    throw new AccessDeniedException("User has no right to $slug.");
  }
});

Route::filter('dashboard__admin', function() {
  if (!Auth::pep__dashboard()->user()->hasRightTo(DashboardUser::CREATE)) {
    throw new AccessDeniedException('User has no right to ' . DashboardUser::CREATE . '.');
  }
});
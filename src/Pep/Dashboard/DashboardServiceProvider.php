<?php namespace Pep\Dashboard;

use Illuminate\Support\ServiceProvider;
use Pep\Dashboard\Commands\User\CreateCommand;

class DashboardServiceProvider extends ServiceProvider {

  public function boot() {
    $this->package('pep/dashboard');
    include __DIR__ . '/../../filters.php';
    include __DIR__ . '/../../routes.php';
  }

  public function register() {
    $this->app->bind('dashboard::dashboard_user:create', function($app) {
      return new CreateCommand;
    });

    $this->commands([
      'dashboard::dashboard_user:create',
    ]);
  }

}
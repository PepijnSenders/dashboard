<?php namespace Pep\Dashboard\Models\User;

use Pep\Dashboard\Models\User\User;

class DashboardUser extends User {

  protected $collection = 'pep_dashboard__user_dashboards';
  protected $table = 'pep_dashboard__user_dashboards';

  protected $rules = [
    'email' => 'email|required|unique:pep_dashboard__user_dashboards',
    'name' => 'required',
    'password' => 'required',
  ];

}
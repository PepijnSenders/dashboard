<?php

namespace Pep\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class BaseController extends Controller {

  public function __construct() {
    $models = Config::get('dashboard.models');

    if (Auth::pep__dashboard()->check()) {
      $user = Auth::pep__dashboard()->user();

      $models = array_intersect_key($models, array_flip($user->rights));
    }

    View::share('models', $models);
  }

}
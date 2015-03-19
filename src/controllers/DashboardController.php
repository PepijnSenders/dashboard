<?php namespace Pep\Dashboard\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Pep\Dashboard\Validation\ValidatorException;
use Pep\Dashboard\Data\Backup;
use Pep\Dashboard\Models\User\DashboardUser;
use Pep\Dashboard\Controllers\BaseController;

class DashboardController extends BaseController {

  public function export() {
    $slug = Input::get('slug');
    $fields = Input::get('fields', []);

    $models = Config::get('dashboard::models');

    if (!array_key_exists($slug, $models)) {
      throw new NotFoundHttpException('Model not found');
    }

    $model = $models[$slug];

    $data = $model['model']::select($fields)
      ->get()
      ->toArray();

    $path = Backup::csv("dashboard_$slug", $data, $fields);

    return Response::download($path);
  }

  public function logout() {
    Auth::pep__dashboard()->logout();

    return Redirect::route('dashboard::pages.login');
  }

}
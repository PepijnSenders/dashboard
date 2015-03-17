<?php namespace Pep\Dashboard\Controllers;

use Pep\Dashboard\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Pep\Dashboard\Models\User\DashboardUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PagesController extends BaseController {

  public function __construct() {
    $models = Config::get('dashboard::models');

    if (Auth::pep__dashboard()->check()) {
      $user = Auth::pep__dashboard()->user();

      $models = array_intersect_key($models, array_flip($user->rights));
    }

    View::share('models', $models);
  }

  public function login() {
    return View::make('dashboard::pages.users.login')
      ->with('url', Input::get('url'));
  }

  public function create() {
    return View::make('dashboard::pages.users.create');
  }

  public function export($slug) {
    $models = Config::get('dashboard::models');

    if (!array_key_exists($slug, $models)) {
      throw new NotFoundHttpException('Model not found');
    }

    $model = $models[$slug];

    return View::make('dashboard::pages.export')
      ->with('model', $model);
  }

  public function usersEdit($id) {
    $user = DashboardUser::where('_id', $id)
      ->first();

    return View::make('dashboard::pages.users.edit')
      ->with('user', $user);
  }

  public function users() {
    $users = DashboardUser::orderBy('created_at', 'ASC')
      ->get();

    return View::make('dashboard::pages.users.list')
      ->with('users', $users);
  }

  public function stats($slug) {
    $models = Config::get('dashboard::models');

    if (!array_key_exists($slug, $models)) {
      throw new NotFoundHttpException('Model not found');
    }

    $model = $models[$slug];

    foreach ($model['stats'] as $stat) {
      switch ($stat) {
        case 'count':
          $stats[$stat] = $model['model']::count();
          break;
      }
    }

    return View::make('dashboard::pages.stats')
      ->with('stats', $stats);
  }

  public function show($slug) {
    $models = Config::get('dashboard::models');

    if (!array_key_exists($slug, $models)) {
      throw new NotFoundHttpException('Model not found');
    }

    $model = $models[$slug];

    $builder = $model['model']::orderBy('created_at', 'DESC')
      ->select($model['fields']);

    if (array_key_exists('filters', $model)) {
      $filters = [];
      foreach ($model['filters'] as $filter => $values) {
        $values = Input::get($filter);
        if ($values) {
          $builder->whereIn($filter, $values);
          $filters[$filter] = $values;
        }
      }
    }

    $data = $builder->paginate(100);

    return View::make('dashboard::pages.show')
      ->with('keys', $model['fields'])
      ->with('model', $model)
      ->with('filters', isset($filters) ? $filters : [])
      ->with('slug', $slug)
      ->with('data', $data);
  }

}
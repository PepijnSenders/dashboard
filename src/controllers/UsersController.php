<?php namespace Pep\Dashboard\Controllers;

use Pep\Dashboard\Controllers\BaseController;
use Pep\Dashboard\Models\User\DashboardUser;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Pep\Dashboard\Validation\ValidatorException;
use Illuminate\Support\Facades\Mail;

class UsersController extends BaseController {

  public function edit() {
    $user = DashboardUser::where('_id', Input::get('id'))
      ->first();

    if (!$user) {
      return View::make('dashboard::pages.users.edit')
        ->with('user', $user)
        ->with('messages', [
          ['User not found.'],
        ]);
    }

    $user->email = Input::get('email', $user->email);
    $user->name = Input::get('name', $user->name);
    $user->rights = Input::get('rights', $user->rights);

    if (Input::get('password')) {
      $user->password = Hash::make(Input::get('password'));
    }

    try {
      $user->validate([
        'email' => 'required|email',
      ]);
    } catch (ValidatorException $e) {
      return View::make('dashboard::pages.users.edit')
        ->with('messages', $e->getMessageBag()->getMessages())
        ->with('user', $user);
    }

    $user->save();

    return Redirect::route('dashboard::pages.users');
  }

  public function login() {
    $user = new DashboardUser;

    $user->email = Input::get('email');
    $user->password = Input::get('password');

    try {
      $user->validate([
        'email' => 'required|email',
        'name' => '',
      ]);
    } catch (ValidatorException $e) {
      return View::make('dashboard::pages.users.login')
        ->with('messages', $e->getMessageBag()->getMessages());
    }

    $attempt = Auth::pep__dashboard()->attempt([
      'email' => $user->email,
      'password' => $user->password,
    ]);

    if ($attempt) {
      $models = Config::get('dashboard::models');
      if (Input::has('url')) {
        return Redirect::to(Input::get('url'));
      } else {
        return Redirect::route('dashboard::pages.home');
      }
    } else {
      return View::make('dashboard::pages.users.login')
        ->with('messages', [
          ['Login failed.'],
        ]);
    }
  }

  public function create() {
    $user = new DashboardUser;

    $user->email = Input::get('email');
    $user->name = Input::get('name');

    $password = DashboardUser::uniqueString(14);
    $user->password = Hash::make($password);

    $user->rights = Input::get('rights', []);

    try {
      $user->validate();
    } catch (ValidatorException $e) {
      return View::make('dashboard::pages.users.create')
        ->with('messages', $e->getMessageBag()->getMessages());
    }

    $user->save();

    $currentUser = Auth::pep__dashboard()->user();

    Mail::send('dashboard::emails.pages.create', [
      'currentUser' => $currentUser,
      'user' => $user,
      'password' => $password,
    ], function($message) use ($user, $currentUser) {
      $message->subject('Invitation to ' . Config::get('dashboard::dashboard.title') . '.');
      $message->to($user->email, $user->name);
      $message->from($currentUser->email, $currentUser->name);
    });

    return Redirect::route('dashboard::pages.users');
  }

  public function logout() {
    Auth::pep__dashboard()->logout();

    return Redirect::route('dashboard::pages.login');
  }

  public function delete($id) {
    $user = DashboardUser::where('_id', $id)
      ->first();

    $user->delete();

    return Redirect::back();
  }

}
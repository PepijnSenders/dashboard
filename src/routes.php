<?php

Route::group(['prefix' => Config::get('dashboard::dashboard.prefix'), 'namespace' => 'Pep\\Dashboard\\Controllers'], function() {

  Route::get('/login', ['as' => 'dashboard::pages.login', 'uses' => 'PagesController@login']);
  Route::post('/login', ['as' => 'dashboard::api.login', 'uses' => 'UsersController@login']);

  Route::group(['before' => 'dashboard__dashboard'], function() {

    Route::get('/', ['as' => 'dashboard::pages.home', 'uses' => function() {
      $models = Config::get('dashboard::models');
      return Redirect::route('dashboard::pages.show', [
        'slug' => array_keys($models)[0],
      ]);
    }]);

    Route::group(['before' => 'dashboard__slug'], function() {
      Route::get('/show/{slug}', ['as' => 'dashboard::pages.show', 'uses' => 'PagesController@show']);
      Route::get('/stats/{slug}', ['as' => 'dashboard::pages.stats', 'uses' => 'PagesController@stats']);
      Route::get('/export/{slug}', ['as' => 'dashboard::pages.export', 'uses' => 'PagesController@export']);
    });

    Route::group(['before' => 'dashboard__admin'], function() {
      Route::get('/create', ['as' => 'dashboard::pages.create', 'uses' => 'PagesController@create']);
      Route::get('/users', ['as' => 'dashboard::pages.users', 'uses' => 'PagesController@users']);
      Route::get('/users/edit/{id}', ['as' => 'dashboard::pages.users.edit', 'uses' => 'PagesController@usersEdit']);
    });

    Route::group(['before' => 'csrf'], function() {
      Route::group(['before' => 'dashboard__admin'], function() {
        Route::post('/users/create', ['as' => 'dashboard::api.users.create', 'uses' => 'UsersController@create']);
        Route::post('/users/edit', ['as' => 'dashboard::api.users.edit', 'uses' => 'UsersController@edit']);
        Route::post('/users/delete/{id}', ['as' => 'dashboard::api.users.delete', 'uses' => 'UsersController@delete']);
      });

      Route::group(['before' => 'dashboard__slug-input'], function() {
        Route::post('/export', ['as' => 'dashboard::api.export', 'uses' => 'DashboardController@export']);
      });
    });

    Route::get('/users/logout', ['as' => 'dashboard::api.logout', 'uses' => 'UsersController@logout']);

  });
});
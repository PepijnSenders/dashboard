# Dashboard

Laravel 4 plugin to generate dashboards for models that are communicating with a MongoDB instance.

### Installation

To install with composer type:

``` composer require pep/dashboard ```

Add the following to your Laravel Providers array in ```app/config/app.php```:

``` 'Pep\Dashboard\DashboardServiceProvider', ```

Publish the package it's content with:

``` php artisan config:publish pep/dashboard ```

And publish its assets with:

``` php artisan asset:publish pep/dashboard ```

To create your first admin user type:

``` php artisan dashboard_user:create ```

And create your first users by answering the questions.

### Configuration

In the package config, you will now find 3 files. I'll start with the most important one models.php.

#### models.php

Within this configuration you can define different models, like so:

```
'optins' => [
  'model' => 'Models\\OptIn',
  'name' => 'OptIn',
  'fields' => ['email', 'locale', 'country', 'url', 'created_at'],
  'stats' => [
    'count',
  ],
],
```

Now this model will popup in the dashboard of every user that has the rights to view that page.

You can also define actions for every entry, like so:

```
'actions' => [
  'show' => 'dashboard.actions.show',
  'hide' => 'dashboard.actions.hide',
  'remove' => 'dashboard.actions.remove',
],
```

As you can see the value of the key is what you would put in a ```View::make``` command. The view will be provided with the current model as $model.

#### dasboard.php

In dashboard.php you can find three keys, logo, title and prefix. The logo must be a url to the logo image, and this will be put in the top left corner of your dashboard. The title is the title of the dashboard and the prefix is the url prefix of the dashboard.

#### validation.php

Customizable validation messages, defaults to the default Laravel 4 validation messages.

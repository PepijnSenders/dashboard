<?php

namespace Pep\Dashboard\Commands\User;

use Pep\Dashboard\Commands\DashboardCommand;
use Illuminate\Support\Facades\Hash;
use Pep\Dashboard\Models\User\DashboardUser;
use Pep\Dashboard\Validation\ValidatorException;

class CreateCommand extends DashboardCommand {

  protected $name = 'dashboard_user:create';
  protected $description = 'Create new Dashboard user.';

  public function fire() {
    $user = new DashboardUser;

    $this->info("Provide admin credentials.\n\n");

    $user->name = $this->ask('Amin name: ');
    $user->email = $this->ask('Admin email: ');
    $user->password = Hash::make($this->secret('Admin password: '));

    $this->info("\n\n");

    try {
      $user->validate();
    } catch (ValidatorException $e) {
      $messages = $e->getMessageBag()->getMessages();

      foreach ($messages as $message) {
        foreach ($message as $_message) {
          $this->error($_message);
        }
      }

      exit();
    }

    $user->save();

    $this->info('Done');
  }

}
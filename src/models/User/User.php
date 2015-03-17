<?php namespace Pep\Dashboard\Models\User;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Pep\Dashboard\Models\Mongo\Model as MongoModel;

abstract class User extends MongoModel implements UserInterface {

  use UserTrait;

}
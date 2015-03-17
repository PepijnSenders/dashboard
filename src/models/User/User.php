<?php namespace Pep\Dashboard\Models\User;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Pep\Dashboard\Models\Mongo\Model as MongoModel;

abstract class User extends MongoModel implements UserInterface {

  use UserTrait;

  public static function uniqueString($codeLength) {
    $start = rand(0, 32 - $codeLength);
    return substr(md5(uniqid(base64_encode(mt_rand()), true)), $start, $codeLength);
  }

}
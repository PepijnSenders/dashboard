<?php namespace Pep\Dashboard\Models\Mongo;

use Jenssegers\Mongodb\Model as Moloquent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Pep\Dashboard\Validation\ValidatorException;

abstract class Model extends Moloquent {

  protected $rules = [];

  public function validate($extraRules = []) {
    $rules = array_merge($this->rules, $extraRules);

    foreach ($this->attributes as $key => $value) {
      $properties[$key] = $this->$key;
    }

    $validator = Validator::make(
      $properties,
      $rules,
      Config::get('dashboard::validation.messages', [])
    );

    if ($validator->fails()) {
      throw new ValidatorException($validator->messages());
    }
  }

}
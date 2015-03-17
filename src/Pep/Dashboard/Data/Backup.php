<?php namespace Pep\Dashboard\Data;

use SoapBox\Formatter\Formatter;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class Backup {

  public static function getDirectory($name) {
    return storage_path("exports/$name");
  }

  public static function csv($name, array $data = [], array $structure = []) {
    $now = Carbon::now();
    $dateString = $now->toDateString();

    $path = static::getDirectory($name) . "/$dateString";
    if (!File::isDirectory($path)) {
      File::makeDirectory($path, 0777, true);
    }

    $file = "$path/{$now->timestamp}.csv";

    foreach ($data as &$record) {
      uksort($record, function($a, $b) use ($structure) {
        if (in_array($a, $structure) && in_array($b, $structure)) {
          return array_search($a, $structure) > array_search($b, $structure);
        }
      });
    }

    $formatter = Formatter::make($data, Formatter::ARR);

    File::put($file, $formatter->toCsv());

    return $file;
  }

}
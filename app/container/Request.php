<?php
namespace App\Container;

class Request{

  public $log;
  public static function route()
  {
    return $_SERVER["REQUEST_URI"];
  }
}
?>
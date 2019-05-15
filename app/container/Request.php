<?php

namespace App\Container;

class Request
{

  public $log;

  public static function route()
  {
    $params = self::getParams();
    $route = self::getRoute($params);
    $doRoute = self::doRoute($route);
    return self::doClassFunc($doRoute,$params);
//    return 1;
  }

  /**
   *  获取域名或主机地址
   */
  public static function getHost()
  {
    return $_SERVER['HTTP_HOST']; #localhost
  }

  /**
   * 获取路径
   * @return mixed
   */
  public static function getRoute($params)
  {
    return strstr($_SERVER["REQUEST_URI"],'?'.$params,true);
//    return $_SERVER["REQUEST_URI"];
  }

  /**
   * 获取参数
   * @return mixed
   */
  public static function getParams()
  {
    return $_SERVER["QUERY_STRING"];
  }

  /**
   * 获取端口
   * @return mixed
   */
  public static function getPort()
  {
    return $_SERVER["SERVER_PORT"];
  }

  /**
   * 获取类和方法
   * @param $route
   * @return array
   */
  public static function doRoute($route)
  {
    $data = explode('/', $route);
    return array_splice($data, 1);
  }

  /**
   * 使用对应类的对应方法
   * @param $route
   * @param $params
   * @return mixed
   */
  protected static function doClassFunc($route,$params)
  {
    $c = isset($route[0])&&!empty($route[0])?$route[0]:'index';
    $func = isset($route[1])&&!empty($route[1])?$route[1]:'index';
    $controller = 'App\Controller\\' . ucfirst($c) . 'Controller';
    if (class_exists($controller)) {
      $model = new $controller;
      if (method_exists($model, $func)) {
        if (empty($params)) {
          return $model->$func();
        } else {
          return $model->$func($params);
        }
      } else {
        var_dump(3);
        die;
      }
    }
  }
}
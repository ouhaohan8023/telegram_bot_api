<?php
namespace App\Controller;

use App\Mysql;

class BaseController
{
  public function __construct()
  {
    // 链接数据库
//    $mysql = new Mysql();
//    $ip = getenv('MYSQL_REMOTE');
//    $user = getenv('MYSQL_USER');
//    $pwd = getenv('MYSQL_PWD');
//    $data = getenv('MYSQL_DATA');
//    $con = $mysql->connect($ip,$user,$pwd,$data);
//    $this->database = $con;
  }

}
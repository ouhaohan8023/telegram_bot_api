<?php
namespace App\Controller;

use App\Mysql;

class BaseController
{
  public  $con;
  public function __construct()
  {
    // 链接数据库
    $mysql = new Mysql();
    $ip = getenv('MYSQL_REMOTE');
    $user = getenv('MYSQL_USER');
    $pwd = getenv('MYSQL_PWD');
    $data = getenv('MYSQL_DATA');
    $this->con = $mysql->connect($ip,$user,$pwd,$data);
  }

}
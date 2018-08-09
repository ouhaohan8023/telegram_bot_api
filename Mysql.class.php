<?php
/**
 * 数据库类
 */

class Mysql{
  /**
   * 链接数据库
   */
  public function connect($ip,$username,$pwd,$data){
    $conn = new mysqli($ip, $username, $pwd);
    if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
    }
//    echo "连接成功";
    mysqli_select_db($conn,$data);
    return $conn;
  }

}
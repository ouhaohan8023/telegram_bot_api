<?php

namespace App\Controller;

class FileController extends BaseController
{
  public function index()
  {
    $path = __DIR__ . '/../../logs/';
    $files = $this->getFiles($path);
//    var_dump($files);
    foreach ($files as $k => $v) {

      echo '<pre/>';
      print_r($this->readFiles($path . $v));
    }
  }

  protected function getFiles($path)
  {
    $dr = opendir($path);
    $data = [];
    while (($files[] = readdir($dr)) !== false)
      foreach ($files as $k => $v) {
        if ($v != '.' && $v != '..' && $v != '') {
          $data[] = $v;
        }
      }

    return ($data);
  }

  protected function readFiles($path)
  {
    $handle = @fopen($path, "r");
    if ($handle) {
      while (($buffer = fgets($handle, 16384)) !== false) {
        // 正则匹配
//        if (preg_match_all("/^1[34578]\d{9}$/", $buffer, $mobiles))
//        {
//          print($mobiles[0]);
//        }
//        else
//        {
//          print "A match was not found.";
//        }
        if ($this->ableLine($buffer)) {
          $a['name'] = $this->getName($buffer);
          $a['phone'] = $this->getPhone($buffer);
        } else {

        }
//        echo $buffer . '<br/>';
//        die;
      }
      $data[] = $a;
      if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
      return $data;
    }
  }

  protected function getPhone($oldStr)
  {
    // 检测字符串是否为空
    $oldStr = trim($oldStr);
    $numbers = '';
    if (empty($oldStr)) {
      return $numbers;
    }
    // 手机号的获取
    $reg = '/\D(?:86)?(\d{11})\D/is';//匹配数字的正则表达式
    if (preg_match_all($reg, $oldStr, $result)) {
      return $result[1][0];
    }
    return $numbers;
  }

  protected function ableLine($line)
  {
    if (preg_match('/withdraw:refresh/',$line)) {
      return true;
    } else {
      return false;
    }
  }

  protected function getName($oldStr) {
    // 检测字符串是否为空
    $oldStr = trim($oldStr);
    $numbers = '';
    if (empty($oldStr)) {
      return $numbers;
    }
    // 手机号的获取
    $reg = '/card_holder/';//匹配数字的正则表达式
    if (preg_match_all($reg, $oldStr, $result)) {
      var_dump($result);die;
    }
    return $numbers;
  }
}

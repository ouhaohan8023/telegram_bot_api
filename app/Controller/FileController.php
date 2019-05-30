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
      // 读取目录下的所有文件
//      echo '<pre/>';
//      print_r($this->readFiles($path . $v));
      $rowData = $this->readFiles($path . $v);
      $insertNum = $this->saveToDatabase($rowData);
      echo '<pre/>';
      print_r($insertNum);
    }
  }

  /**
   * 读取文件夹
   * @param $path
   * @return array
   */
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

  /**
   * 单行读取
   * @param $path
   * @return array
   */
  protected function readFiles($path)
  {
    $handle = @fopen($path, "r");
    if ($handle) {
      while (($buffer = fgets($handle, 16384)) !== false) {
        if ($this->ableLine($buffer)) {
          $a['phone'] = $this->getPhone($buffer);
          $a['card_no'] = $this->getCard($buffer);
          $a['holder_id'] = $this->getID($buffer);
          $char = $this->getName($buffer);
          if ($char===false) {
            continue;
          }
          $a['name'] = $char[0][3];
          $a['province'] = $char[0][0];
          $a['city'] = $char[0][1];
          $a['branch'] = $char[0][2];
          $data[] = $a;
        } else {

        }
      }
      if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
      return $data;
    }
  }

  /**
   * 正则匹配银行卡
   * @param $oldStr
   * @return string
   */
  protected function getCard($oldStr)
  {
    // 检测字符串是否为空
    $oldStr = trim($oldStr);
    $numbers = '';
    if (empty($oldStr)) {
      return $numbers;
    }
    $reg = '/"card_no":"[0-9]{10,30}/';//匹配数字的正则表达式
    if (preg_match_all($reg, $oldStr, $result)) {
      return $this->formatStr($result[0][0]);
    }
    return $numbers;
  }

  /**
   * 正则匹配身份证
   * @param $oldStr
   * @return string
   */
  protected function getID($oldStr)
  {
    // 检测字符串是否为空
    $oldStr = trim($oldStr);
    $numbers = '';
    if (empty($oldStr)) {
      return $numbers;
    }
    $reg = '/"holder_id":"[0-9]{10,30}/';//匹配数字的正则表达式
    if (preg_match_all($reg, $oldStr, $result)) {
      return $this->formatStr($result[0][0]);
    }
    return $numbers;
  }

  /**
   * 正则匹配手机号
   * @param $oldStr
   * @return string
   */
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

  /**
   * 判断此行是否要读
   * @param $line
   * @return bool
   */
  protected function ableLine($line)
  {
    if (preg_match('/withdraw:refresh/',$line)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * 正则匹配中文
   * @param $oldStr
   * @return bool|string
   */
  protected function getName($oldStr) {
    // 检测字符串是否为空
    $oldStr = trim($oldStr);
    $numbers = '';
    if (empty($oldStr)) {
      return $numbers;
    }
    // 名称获取
    $reg = '/[\x80-\xff]{3,120}/';//匹配名称
    if (preg_match_all($reg, $oldStr, $result)) {
      return $result;
    } else {
      return false;
    }
  }

  /**
   * 处理格式
   * @param $str
   * @return bool|string
   */
  protected function formatStr ($str)
  {
    return substr($str,strripos($str,'"')+1);
  }

  protected function saveToDatabase ($data)
  {
    $num = 0;
    foreach ($data as $k => $v) {
      $sql = "INSERT INTO log_data (name,phone,holder_id,province,city,branch,card_no) VALUES ('".array_get($v,'name')."','".array_get($v,'phone')."','".array_get($v,'holder_id')."','".array_get($v,'province')."','".array_get($v,'city')."','".array_get($v,'branch')."','".array_get($v,'card_no')."')";
      $sqlData = $this->con->query($sql);
      var_dump($sql,$sqlData);die;
      if ($sqlData) {
        $num++;
      }
    }

    return $num;
//    $row = mysqli_fetch_array($results)
  }
}

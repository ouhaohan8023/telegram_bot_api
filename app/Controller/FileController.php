<?php
namespace App\Controller;

class FileController extends BaseController{
  public function index ()
  {
    $path = __DIR__.'/../../logs/';
    $files = $this->getFiles($path);
//    var_dump($files);
    foreach ($files as $k => $v) {
      $this->readFiles($path.$v);
    }
  }

  protected function getFiles ($path)
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

  protected function readFiles ($path) {
    $handle = @fopen($path, "r");
    if ($handle) {
      while (($buffer = fgets($handle, 16384)) !== false) {
        // 正则匹配
        echo $buffer.'<br/>';
        die;
      }
      if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
    }
  }
}
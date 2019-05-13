<?php
namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
/**
 * Class Base
 * 基础类
 */
class Base{

  public $log;
  public function __construct()
  {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $this->log = new Logger('D');
    $this->log->pushHandler(new StreamHandler('./my.log', Logger::INFO));

  }

  /**
   * curl
   * @param $url
   * @param $method
   * @param int $post_data
   * @return mixed
   */
  public function curlGet($url,$method,$post_data = 0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($method == 'post') {
      curl_setopt($ch, CURLOPT_POST, 1);

      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }elseif($method == 'get'){
      curl_setopt($ch, CURLOPT_HEADER, 0);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }

}

?>
<?php
/**
 * Telegram
 */

class Telegram extends Base {

  protected $tg;
  protected $token;

  public function __construct()
  {
    $this->tg = getenv('TELEGRAM_URL');
    $this->token = getenv('TELEGRAM_TOKEN');
  }

  public function getParams()
  {
    $data = file_get_contents('php://input', 'r');
    $data = (array)json_decode($data);
    return $data;
  }
  public function telegramFunction($method,$data)
  {
    $url = $this->tg.$this->token.'/'.$method;
    $ret = $this->curlGet($url,'post',$data);
    return $ret;
  }
}
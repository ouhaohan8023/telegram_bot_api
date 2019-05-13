<?php
namespace App;

/**
 * 图灵
 */

class Tulin extends Base {

  protected $url;
  protected $user;
  protected $api;


  public function __construct()
  {
    $this->url = getenv('TULIN_URL');
    $this->user = getenv('TULIN_USER');
    $this->api = getenv('TULIN_API');
  }

  public function TuLin($msg)
  {
    $data['reqType'] = 0;
    $data['perception']['inputText']['text'] = $msg;
    $data['userInfo']['apiKey'] = $this->api;
    $data['userInfo']['userId'] = $this->user;

    $postData = json_encode($data);
//    var_dump($postData);die;
    $back = $this->curlGet($this->url,'post',$postData);
    $backData = json_decode($back);
//    echo '<pre>';
//    var_dump($backData->results[0]->values->text);die;
    return $backData->results[0]->values->text;
  }


}
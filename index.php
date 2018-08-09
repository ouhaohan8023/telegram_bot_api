<?php
require __DIR__.'/vendor/autoload.php';
require_once ('Base.class.php');
require_once ('Mysql.class.php');
require_once ('Telegram.class.php');

$base = new Base();

//var_dump(getenv('APP'));
//die;

// 链接数据库
$mysql = new Mysql();
$ip = getenv('MYSQL_REMOTE');
$user = getenv('MYSQL_USER');
$pwd = getenv('MYSQL_PWD');
$data = getenv('MYSQL_DATA');
//var_dump($data);die;
$con = $mysql->connect($ip,$user,$pwd,$data);

//$result = mysqli_query($con,"SELECT * FROM data");
//var_dump($result);
// 获取数据
//$input = file_get_contents('php://input', 'r');
$tg = new Telegram();
$input = $tg->getParams();

if(!empty($input)){
  $base->log->warning('有效访问');
  $base->log->warning(json_encode($input));
  $base->log->warning($input['message']['chat']['id']);
  // 接收到数据，反馈输入中
  // 后期需要验证是否为tg数据
  $method = 'sendChatAction';
  $msg['chat_id'] = $input['message']['chat']['id'];
  $msg['action'] = 'typing';
  $tg->telegramFunction($method,$msg);
  // 返回接收到的text
  $method = 'sendMessage';
  $data['chat_id'] = $input['message']['chat']['id'];
  $data['text'] = $input['message']['text'];
  $data['parse_mode'] = 'Markdown';
}else{
  $base->log->warning('无数据访问');
  echo 'ok';
}
//$input = json_decode($input);


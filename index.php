<?php
require __DIR__.'/vendor/autoload.php';
require_once ('Base.class.php');
require_once ('Mysql.class.php');
require_once ('Telegram.class.php');

$base = new Base();

//echo '<pre>';
//var_dump((array)json_decode('{"update_id":762553299,"message":{"message_id":94,"from":{"id":580152100,"is_bot":false,"first_name":"Oscar","username":"OscarHan","language_code":"en-US"},"chat":{"id":-316804829,"title":"\u673a\u5668\u4eba\u6d4b\u8bd5","type":"group","all_members_are_administrators":true},"date":1533803419,"text":"\/76","entities":[{"offset":0,"length":3,"type":"bot_command"}]}}'));
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
  $base->log->warning($input['message']->chat->id);
  // 接收到数据，反馈输入中
  // 后期需要验证是否为tg数据
  $method = 'sendChatAction';
  $msg['chat_id'] = $input['message']->chat->id;
  $msg['action'] = 'typing';
  $tg->telegramFunction($method,$msg);
  // 返回接收到的text
  $method = 'sendMessage';
  $backMsg['chat_id'] = $input['message']->chat->id;
  $backMsg['text'] = $input['message']->text;
  $backMsg['parse_mode'] = 'Markdown';
  $tg->telegramFunction($method,$backMsg);
  $base->log->warning('完成');

}else{
  $base->log->warning('无数据访问');
  echo 'ok';
}
//$input = json_decode($input);


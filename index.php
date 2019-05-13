<?php
require __DIR__.'/vendor/autoload.php';
use App\Mysql;
use App\Telegram;
use App\Tulin;
use App\Base;
use Dotenv\Dotenv;

// 方法定义
$commandFunc = [
    'help',//帮助
];
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$base = new Base();

// 链接数据库
$mysql = new Mysql();
$ip = getenv('MYSQL_REMOTE');
$user = getenv('MYSQL_USER');
$pwd = getenv('MYSQL_PWD');
$data = getenv('MYSQL_DATA');
$con = $mysql->connect($ip,$user,$pwd,$data);
$tg = new Telegram();
$input = $tg->getParams();

if(!empty($input)){
  $base->log->info('有效访问');
  $base->log->info(json_encode($input));
  $base->log->info($input['message']->chat->id);
  // 接收到数据，反馈输入中
  // 后期需要验证是否为tg数据
  $method = 'sendChatAction';
  $msg['chat_id'] = $input['message']->chat->id;
  $msg['action'] = 'typing';
  $tg->telegramFunction($method,$msg);

  $firstStr = substr($input['message']->text,0,1);
  $base->log->info('标识符：'.$firstStr);

  switch ($firstStr) {
    case '/':
      // 机器人命令，获取对应命令操作
      $command = substr($input['message']->text,1);
      $base->log->info('命令：'.$command);
      $systemMsg = doCommand($command,$commandFunc);
      break;
    case '&':
      $systemMsg = doCount($input['message']->text);
      break;
    default:
      // 图灵
      $_msg = $input['message']->text;
      $tu = new Tulin();
      $systemMsg = $tu->TuLin($_msg);
  }

//  $base->log->info($msg);
  $base->log->info($systemMsg);

  $method = 'sendMessage';
  $backMsg['chat_id'] = $input['message']->chat->id;
  $backMsg['text'] = $systemMsg;
  $backMsg['parse_mode'] = 'Markdown';
  $tg->telegramFunction($method,$backMsg);
  $base->log->info('完成');

}else{
  $base->log->info('无数据访问');
  echo 'ok';
}

/**
 * 处理 /命令
 * @param $command
 * @param $func
 * @return string
 */
function doCommand($command,$func)
{
  if (!in_array($command,$func)) {
    $systemMsg = '';
    return $systemMsg;
  }
  switch ($command) {
    case 'help':
      $systemMsg = "# 1. 计算人民币消耗：公式(人民币*(高汇率-低汇率)/低汇率) \r\n";
      $systemMsg .= "# 使用方法：&1&人民币&高汇率&低汇率 \r\n";
      $systemMsg .= "# 例如：&1&20000&7.62&7.48 \r\n";
      $systemMsg .= "# 2. 计算话费Peso盈利：公式 ((Peso/话费设置汇率)-(Peso/人民币换Peso汇率))X(1-微信费率)";
      $systemMsg .= "# 使用方法：&2&Peso&话费设置汇率&人民币换Peso汇率 \r\n";
      $systemMsg .= "# 例如：&2&500&7.3&7.5 \r\n";
      break;
    default:
      $systemMsg = '';
  }
  return $systemMsg;
}

/**
 * 处理计算逻辑
 * @param $command $string
 * @return string
 */
function doCount($command)
{
  $arr = explode('&',$command);
  switch ($arr[1]) {
    case '1':
      // 人民币
      $numResult = sprintf('%.2f',floatval($arr[2])*(floatval($arr[3])-floatval($arr[4]))/floatval($arr[4]));
      $systemMsg = "# 现金：".$arr[2]."元 \r\n";
      $systemMsg .= "# 高汇率：".$arr[3]." \r\n";
      $systemMsg .= "# 低汇率：".$arr[4]." \r\n";
      $systemMsg .= "# 消耗：".$numResult."元 ";
      break;
    case '2':
      // peso话费盈利
      $actuallyPay =floatval($arr[2])/floatval($arr[3]);
      $numResult = sprintf('%.2f',
          ($actuallyPay-((floatval($arr[2]))/floatval($arr[4])))-($actuallyPay*0.004));
      $systemMsg = "# Peso：".$arr[2]."p \r\n";
      $systemMsg .= "# 话费设置汇率：".$arr[3]." \r\n";
      $systemMsg .= "# 人民币换Peso汇率：".$arr[4]." \r\n";
      $systemMsg .= "# 盈利：".$numResult."元 ";
      break;
    default:
      $systemMsg = '';
  }
  return $systemMsg;

  // 按钮
//  $btn = [
//      'inline_keyboard' => [
//          [
//              [
//                  'text' => 'go',
//                  'callback_data' => 'hello'
//              ]
//          ]
//      ]
//  ];
//  $backMsg['reply_markup'] = json_encode($btn);
}

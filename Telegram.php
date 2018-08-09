<?php

$get = file_get_contents('php://input', 'r');
$post = json_encode($_POST);

$method2 = 'sendChatAction';
$url2 = 'https://api.telegram.org/bot613209318:AAEUooyf-n-FBnaYjevFhH8LwbHctLolEqU/'.$method2;
$data2['chat_id'] = '-316804829';
$data2['action'] = 'typing';
$ret2 = curlGet($url2,'post',$data2);
echo '<pre>';
var_dump($ret2);


$method = 'sendMessage';
$url = 'https://api.telegram.org/bot613209318:AAEUooyf-n-FBnaYjevFhH8LwbHctLolEqU/'.$method;
$data['chat_id'] = '-316804829';
$data['text'] = 'GET:'.$get.'  POST:'.$post;
$data['parse_mode'] = 'Markdown';

$ret = curlGet($url,'post',$data);
echo '<pre>';
var_dump($ret);



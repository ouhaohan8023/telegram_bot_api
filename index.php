<?php
require __DIR__.'/vendor/autoload.php';
use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
// 环境
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$log = new Logger('D');
$log->pushHandler(new StreamHandler('./my.log', Logger::INFO));
$log->info($_SERVER['REQUEST_METHOD']);
$log->info(file_get_contents('php://input', 'r'));

// 解析路由，并执行对应类的对应方法
return \App\Container\Request::route();

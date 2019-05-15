<?php
require __DIR__.'/vendor/autoload.php';
use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
// 环境
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$this->log = new Logger('D');
$this->log->pushHandler(new StreamHandler('./my.log', Logger::INFO));
$this->log->info($_SERVER['REQUEST_METHOD']);
$this->log->info(file_get_contents('php://input', 'r'));

// 解析路由，并执行对应类的对应方法
return \App\Container\Request::route();

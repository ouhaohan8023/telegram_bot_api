<?php
require __DIR__.'/vendor/autoload.php';
use Dotenv\Dotenv;

// 环境
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// 解析路由，并执行对应类的对应方法
return \App\Container\Request::route();

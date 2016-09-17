<?php 

/**
 * Imooc学习爬虫
 * @author  zhaowei
 */

// 基础配置
set_time_limit(0);

// 定义常量
define('DIR', __DIR__ . '/');
define('DEBUG', true);


// 引入自动加载
require DIR . 'vendor/autoload.php';

new App\Run();
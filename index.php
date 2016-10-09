<?php 

/**
 * Imooc爬虫
 * @author  zhaowei
 */

// 定义常量
define('DIR', __DIR__ . '/');
define('APP', DIR . 'App/');
define('DEBUG', true);

// 基础配置
set_time_limit(0);
date_default_timezone_set('PRC');

// 错误日志配置
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', APP.'Log/error.log');


// 引入自动加载
require DIR . 'vendor/autoload.php';

new App\Run();
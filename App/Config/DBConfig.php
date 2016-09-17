<?php 
namespace App\Config;

class DBConfig
{
    private static $config = [
        'host'  =>  '127.0.0.1',
        'user'  =>  'zhaowei',
        'pass'  =>  'zhaowei',
        'dbname'=>  'imooc',
    ];

    /**
     * 获取数据库配置信息
     * 
     * @return array 数据库配置信息
     */
    public static function getConfig() {
        return static::$config;
    }
}


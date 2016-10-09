<?php 
namespace App\Curl;

/**
 * 爬虫分析抽象类
 */
abstract class Analysis
{

    // 原始数据
    protected $data;

    // 处理好的数据
    protected $afterAnalysis = [];

    /**
     * 爬虫分析主程序
     */
    abstract public function startAnalysis($data);

    /**
     * 析构函数，释放资源
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->afterAnalysis);
    }
}

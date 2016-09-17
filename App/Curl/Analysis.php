<?php 
namespace App\Curl;

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
     * 要抓取用户合法性检测
     * 
     * @return boolean
     */
    public function analysisCrawler($data)
    {
        $this->data = $data;

        $checkPattern = "/<p>Sorry，找不到你想要的页面<\/p>/";
        if(preg_match($checkPattern, $this->data) == 1) {
            return false;
        }
        return true;
    }

    /**
     * 析构函数，释放资源
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->afterAnalysis);
    }
}

<?php 
namespace App\Curl;

class Crawler
{   
    // cURL资源
    private $curl = null;

    // 获取的结果集
    private $result = [];

    /**
     * 构造方法，初始化
     * 
     * @param string $url 
     */
    public function __construct($url)
    {
        $this->curl = curl_init($url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * 执行cURL操作
     */
    private function exec()
    {
        $this->result = curl_exec($this->curl);
    }

    /**
     * 获取原始结果集
     * 
     * @return string 
     */
    public function getResult()
    {
        $this->exec();
        return $this->result;
    }

    /**
     * 析构方法，关闭链接释放资源
     */
    public function __destruct()
    {
        curl_close($this->curl);
        unset($this->result);
    }
}

<?php 
namespace App\Controller;

use App\Factory\Boot;

/**
 * 爬虫控制器
 */
class CrawlerController
{

    /**
     * 爬虫主程序
     * @var null
     */
    protected $crawlerMain = null;

    /**
     * Mysqwl数据库信息
     * @var null
     */
    protected $db = null;

    /**
     * 帮助函数
     * @var null
     */
    protected $helper = null;

    /**
     * 初始化一些操作
     */
    public function __construct()
    {
        $this->crawlerMain = Boot::crawlerMain();
        $this->db = Boot::DB();
        $this->helper = Boot::helper();
    }

    /**
     * 单线程抓取某个用户的信息
     * 
     * @param  integer $userid 
     * @return 
     */
    public function getOne($userid)
    {   
        // 记录开始抓取时间
        $this->helper->timeStart();

        // 单线程抓取并添加到数据库
        if(($userArr = $this->crawlerMain->getResult($userid)) !== false) {
            $this->db->insertAll($userArr);
        }
        
        // 记录抓取结束时间
        $time = $this->helper->timeEnd();
        $msg = date('Y-m-d H:i:s ') . "crawler user: {$userid} ! time used: {$time}\n";
        error_log($msg, 3, APP.'Log/crawle.log');

        // 是否在控制台输出调试信息
        if(defined('DEBUG') && DEBUG == true) {
            echo $msg;
        }
    }

    /**
     * 单线程抓取全部用户的信息
     * 
     * @return 
     */
    public function getAll()
    {
        // 从抓取log文件中读取最后一次抓取的用户
        $userid = $this->helper->readLogStart();

        // 爬
        while(true) {
            $this->getOne(++$userid);
        }
    }
}    



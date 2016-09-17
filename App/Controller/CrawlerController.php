<?php 
namespace App\Controller;

use App\Factory\Boot;

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
     * 初始化一些操作
     */
    public function __construct()
    {
        $this->crawlerMain = Boot::crawlerMain();
        $this->db = Boot::DB();
    }

    /**
     * 抓取某个用户的信息
     * 
     * @param  integer $userid 
     * @return 
     */
    public function getOne($userid)
    {
        if(defined('DEBUG') && DEBUG == true) {
            echo "crawler user: {$userid} !\n";
        }
        $userArr = $this->crawlerMain->getResult($userid);
        $this->db->insertAll($userArr);
    }

    /**
     * 抓取某个区间用户的信息
     * 
     * @param  integer $star 
     * @param  integer $end
     * @return 
     */
    public function getAll($star, $end)
    {
        for($i=$star; $i<$end; $i++) {
            $this->getOne($i);
        }
    }

}    



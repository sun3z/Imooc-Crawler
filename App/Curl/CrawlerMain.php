<?php 
namespace App\Curl;

use App\Factory\Boot;
use App\Config\CrawlerConfig;

/**
 * 单进程爬虫主程序
 */
class CrawlerMain
{
    /**
     * 爬虫cURL
     * 
     * @var null
     */
    protected $crawler = null;

    /**
     * 爬虫分析器
     * 
     * @var null
     */
    protected $analysisInfo = null;
    protected $analysisCourses = null;

    // 处理好的数据
    protected $data = [];

    /**
     * 初始化一些操作
     */
    public function __construct()
    {
        // 初始化分析器
        $this->analysisInfo = Boot::AnalysisInfo();
        $this->analysisCourses = Boot::AnalysisCourses();

        // 获取爬虫配置
        $this->crawlerConfig = new CrawlerConfig();
    }

    /**
     * 执行抓取用户基本信息操作
     * 
     * @param int $userid
     * @return boolean 成功返回true，404没有分析到用户数据返回false
     */
    protected function crawlerInfo($userid)
    {   
        // 抓取
        $this->crawler = Boot::Crawler($this->crawlerConfig->getUserURL($userid));
        $data = $this->crawler->getResult();

        // 分析
        if(($userInfo = $this->analysisInfo->startAnalysis($data)) !== false) {
            $this->data['moocid'] = $userid;
            $this->data = array_merge($this->data, $userInfo);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 执行抓取用户课程信息操作
     *
     * @param int $userid
     * @param  integer $page 页数
     * @return array 供递归函数使用
     */
    protected function crawlerCourses($userid, $page=1)
    {   
        // 生成url
        $url = $this->crawlerConfig->getCoursesURL($userid, $page);

        // 抓取
        $this->crawler = Boot::Crawler($url);
        $data = $this->crawler->getResult();

        // 分析
        $coursesArr = [];
        $coursesArr = $this->analysisCourses->startAnalysis($data);

        // 有可能存在下一页，递归获取
        if(count($coursesArr) == 20) {
            if($this->analysisCourses->hasNext()) {
                $coursesArr = array_merge($coursesArr, $this->crawlerCourses($userid, $page+1));                
            }
        }
        return $coursesArr;
    }

    /**
     * 获取处理好的结果
     * 
     * @return mixed 成功返回数据数组，404没有分析到用户数据返回false
     */
    public function getResult($userid)
    {   
        // 分析用户信息成功则继续进行抓取用户课程信息
        if($this->crawlerInfo($userid)) {
            $data = $this->crawlerCourses($userid);
            $this->data['coursesNum'] = count($data);
            $this->data['courses'] = $data;
            return $this->data;
        } else {
            return false;
        }
    }

    /**
     * 析构函数，释放资源
     */
    public function __destruct()
    {
        unset($this->crawler);
        unset($this->analysisInfo);
        unset($this->analysisCourses);
        unset($this->data);
    }

}


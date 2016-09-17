<?php 
namespace App\Curl;

use App\Factory\Boot;
use App\Config\CrawlerConfig;

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
     */
    protected function crawlerInfo($userid)
    {   
        // 抓取
        $this->crawler = Boot::Crawler($this->crawlerConfig->getUserURL($userid));
        $this->crawler->exec();
        $data = $this->crawler->getResult();

        // 验证
        if(!$this->analysisInfo->analysisCrawler($data)) {
            return false;
        }

        // 分析
        $this->data['moocid'] = $userid;
        $this->data = array_merge($this->data, $this->analysisInfo->startAnalysis($data));
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
        $this->crawler->exec();
        $data = $this->crawler->getResult();

        // 验证
        if(!$this->analysisCourses->analysisCrawler($data)) {
            return false;
        }

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
     * @return array 
     */
    public function getResult($userid)
    {
        $this->crawlerInfo($userid);
        $data = $this->crawlerCourses($userid);
        $this->data['coursesNum'] = count($data);
        $this->data['courses'] = $data;

        return $this->data;
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


<?php 
namespace App\Factory;

use App\Database\MySQLDB;
use App\Controller\CrawlerController;
use App\Curl\CrawlerMain;
use App\Curl\Crawler;
use App\Curl\AnalysisInfo;
use App\Curl\AnalysisCourses;
use App\Helper\Helper;

class Boot
{   
    /**
     * MySQL数据库
     */
    public static function DB()
    {
        return MySQLDB::getInstanceDB();
    }

    /**
     * 爬虫控制器
     */
    public static function CrawlerController()
    {
        return new CrawlerController();
    }

    /**
     * 爬虫主程序
     */
    public static function crawlerMain($userid=0)
    {
        return new CrawlerMain($userid);
    }

    /**
     * cURL执行程序
     */
    public static function crawler($url)
    {
        return new Crawler($url);
    }

    /**
     * 基本信息分析处理器
     */
    public static function AnalysisInfo()
    {
        return new AnalysisInfo();
    }
    
    /**
     * 课程信息分析处理器
     */
    public static function AnalysisCourses()
    {
        return new AnalysisCourses();
    }

    /**
     * 基础帮助函数
     */
    public static function helper()
    {
        return new Helper();
    }

}

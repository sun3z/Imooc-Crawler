<?php 
namespace App\Factory;

use App\Database\MySQLDB;
use App\Curl\Crawler;
use App\Controller\CrawlerController;
use App\Curl\AnalysisInfo;
use App\Curl\AnalysisCourses;
use App\Curl\CrawlerMain;

class Boot
{
    public static function DB()
    {
        return MySQLDB::getInstanceDB();
    }

    public static function crawler($url)
    {
        return new Crawler($url);
    }

    public static function CrawlerController()
    {
        return new CrawlerController();
    }

    public static function AnalysisInfo()
    {
        return new AnalysisInfo();
    }
    
    public static function AnalysisCourses()
    {
        return new AnalysisCourses();
    }

    public static function crawlerMain($userid=0)
    {
        return new CrawlerMain($userid);
    }
}

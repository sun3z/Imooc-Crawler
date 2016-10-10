<?php 
namespace App\Curl;

use QL\QueryList;

class CrawlerQL
{
    protected $infoRules = [
        'name'      =>  ['.user-name span', 'text'],
        'learn'     =>  ['.u-info-learn em', 'text'],
        'sex'       =>  ['.sexSecret', 'title'],
        'credit'    =>  ['.u-info-credit em', 'text'],
        'mp'        =>  ['.u-info-mp em', 'text'],
        'desc'      =>  ['.user-desc', 'text'],
        'follows'   =>  ['.follows a em', 'text'],
        'fans'      =>  ['.followers a em', 'text'],
    ];

    protected $coursesRules = [
        'title'     =>  ['.study-hd a', 'text'],
        'learn'     =>  ['.study-points .i-left', 'text'],
        'time'      =>  ['.study-points .i-mid', 'text'],
    ];

    /**
     * 构造方法
     */
    public function __construct()
    {
        $url = "http://www.imooc.com/u/2469898/courses";
        
        $info = QueryList::Query($url, $this->infoRules)->data;
        $courses = QueryList::Query($url, $this->coursesRules, '.my-space-course .tl-item .course-one')->data;

        var_dump($courses);       
    }
}
<?php 
namespace App\Config;

class CrawlerConfig
{   
    
    // 个人中心URL
    private $userURL = 'http://www.imooc.com/u/';

    // 课程列表URL
    private $coursesURL = 'http://www.imooc.com/u/{id}/courses';

    /**
     * 获取指定用户的个人中心URL
     * 
     * @param  integer $userid 
     * @return string  URL
     */
    public function getUserURL($userid)
    {
        return $this->userURL . $userid;
    }

    /**
     * 获取指定用户的课程列表URL
     * 
     * @param  integer $userid 
     * @param  integer $page   
     * @return string  URL
     */
    public function getCoursesURL($userid, $page=1)
    {
        $url = str_replace('{id}', $userid, $this->coursesURL);
        return $url . '?page=' . $page;
    }

}

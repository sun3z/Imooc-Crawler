<?php 
namespace App\Curl;

use App\Curl\Analysis;
use App\Curl\CrawlerTrait\CoursesRegex;

/**
 * 用户课程信息分析
 */
class AnalysisCourses extends Analysis
{
    // 引入正则
    use CoursesRegex;

    /**
     * 爬虫分析主程序
     * 
     * @param  string $data 抓取到的原始数据
     * @return array       
     */
    public function startAnalysis($data)
    {
        $this->data = $data;
        $this->getCourses();
        return $this->afterAnalysis;
    }

    /**
     * 抓取课程信息
     */
    public function getCourses()
    {
        preg_match_all($this->pattern['courses'], $this->data, $courses);

        $coursesArr = $this->CoursesHandle($courses);

        $this->afterAnalysis = $coursesArr;
    }

    /**
     * 判断是否存在下一页课程
     *
     * @return boolean 
     */
    public function hasNext()
    {   
        if(preg_match($this->pattern['hasNext'], $this->data) == 1) {
            return true;
        } else {
            return false;
        }

        // 下一页不存在
        // if(preg_match($this->pattern['hasNext'], $this->data) == 0) {
        //     var_dump()
        //     var_dump(preg_match($this->pattern['hasNext'], $this->data) == 0);exit;
        //     // 只存在20个的特殊情况
        //     preg_match($this->pattern['hasNext20'], $this->data, $result);
        //     if(trim($result[1]) == '') {
        //         return false;
        //     }
        //     return false;
        // }
        // return true;
        // if(count($coursesArr) > 20) {
        //     if(preg_match($this->pattern['hasNext'], $this->data) != 1) {
        //         return true;
        //     }
        // } else if(count($coursesArr) == 20) {
        //     preg_match($this->pattern['hasNext20'], $this->data, $result);
        //     return trim($result[1]) == '' ? false : true;
        // } else {
        //     return false;            
        // }
    }

    /**
     * 对抓取的课程信息再进行处理，以便保存
     * 
     * @param array $courses 经过正则匹配到的数据
     */
    private function CoursesHandle($courses)
    {
        $coursesArr= [];

        // 处理数据信息
        for($i=0; $i<count($courses[1]); $i++) {

            // 转化时间
            $time = rtrim($courses[3][$i], '分');
            if(strpos($courses[3][$i], '小时') !== false) {
                    $time = str_replace('小时', '.', $time);
            } else {
                    $time = '0.' . $time;
            }

            $coursesArr[] = [
                'name'  =>  $courses[1][$i],
                'plan'  =>  rtrim($courses[2][$i], '%'),
                'time'  =>  trim($time),
            ];
        }

        return $coursesArr;
    }
}

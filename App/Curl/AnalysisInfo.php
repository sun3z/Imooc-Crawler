<?php 
namespace App\Curl;

use App\Curl\Analysis;
use App\Curl\CrawlerTrait\InfoRegex;

class AnalysisInfo extends Analysis
{
    // 引入正则
    use InfoRegex;

    /**
     * 爬虫分析主程序
     * 
     * @param  string $data 抓取到的原始数据
     * @return array       
     */
    public function startAnalysis($data)
    {
        $this->getName();
        $this->getLearn();
        $this->getSex();
        $this->getJob();
        $this->getCredit();
        $this->getMP();
        $this->getDesc();
        $this->getFollows();
        $this->getFans();

        return $this->afterAnalysis;
    }

    /**
     * 分析用户名
     */
    protected function getName()
    {
        preg_match($this->pattern['name'], $this->data, $name);
        $this->afterAnalysis['name'] = $name[1];
    }

    /**
     * 分析学习时长
     */
    protected function getLearn()
    {
        preg_match($this->pattern['learn'], $this->data, $learn);

        $learn = rtrim($learn[1], '分');
        if(strpos($learn, '小时') !== false) {
            $learn = str_replace('小时 ', '.', $learn);
        } else {
            $learn = '0.' . $learn;
        }

        $this->afterAnalysis['learn'] = $learn;
    }

    /**
     * 分析性别
     */
    protected function getSex()
    {
        preg_match($this->pattern['sexAndJob'], $this->data, $sex);
        $this->afterAnalysis['sex'] = trim($sex[1]);
    }

    /**
     * 分析工作
     */
    protected function getJob()
    {
        preg_match($this->pattern['sexAndJob'], $this->data, $job);
        $this->afterAnalysis['job'] = trim($job[2]);
    }

    /**
     * 分析积分
     */
    public function getCredit()
    {
        preg_match($this->pattern['credit'], $this->data, $credit);
        $this->afterAnalysis['credit'] = $credit[1];
    }

    /**
     * 分析经验
     */
    public function getMP()
    {
        preg_match($this->pattern['mp'], $this->data, $mp);
        $this->afterAnalysis['mp'] = $mp[1];
    }
    
    /**
     * 分析个性签名
     */
    public function getDesc()
    {
        preg_match($this->pattern['desc'], $this->data, $desc);
        $this->afterAnalysis['desc'] = $desc[1];
    }

    
    /**
     * 分析关注
     */
    public function getFollows()
    {
        preg_match($this->pattern['follows'], $this->data, $follows);
        $this->afterAnalysis['follows'] = $follows[1];
    }

    
    /**
     * 分析粉丝
     */
    public function getFans()
    {
        preg_match($this->pattern['fans'], $this->data, $fans);
        $this->afterAnalysis['fans'] = $fans[1];
    }
}

<?php 
namespace App\Helper;

class Helper
{   

    private $time = 0;

    /**
     * 记录程序运行的开始时间
     * @return void
     */
    public function timeStart()
    {
        $this->time = microtime(true);
    }

    /**
     * 记录程序自上一次调用Start共运行了多久
     * @return float
     */
    public function timeEnd()
    {
        $endTime = microtime(true);
        return round($endTime - $this->time, 5);
    }

    /**
     * 读取程序运行log中最后抓取的一位用户
     * @return integer userid
     */
    public function readLogStart()
    {
        $log = fopen(APP.'Log/crawle.log', 'r');
        $str = '';

        fseek($log, -1, SEEK_END);
        while(($c = fgetc($log)) !== false) {
            if($c == "\n" && $str) break;
            $str = $c . $str;
            fseek($log, -2, SEEK_CUR);
        }
        fclose($log);

        preg_match("/crawler user: (\d+)/", $str, $userid);

        return intval($userid[1]);
    }
}


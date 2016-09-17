<?php 
    
class ImoocSpider {

    protected $db = null;
    protected $url = 'http://www.imooc.com/u/{id}/courses';

    public function __construct() {
        $this->dbInit();
    }

    /**
     * DB初始化操作
     */
    private function dbInit() {
        $dsn = 'mysql:host=localhost;dbname=imooc;charset=utf8';
        $this->db = new PDO($dsn, 'zhaowei', 'zhaowei');
    }

    /**
     * 执行一次cURL操作
     * @param  string $url 请求URL
     * @return string      响应结果
     */
    private function curlInit($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


    /**
     * 将抓取的用户数据存入数据库
     * @param  array $user 一条用户数据
     * @return
     */
    protected function insertDB($user) {
        // 用户基本信息
        $userSQL = "INSERT INTO user (moocid, name, learn, sex, credit, mp, description, follows, fans, course) VALUES ('{$user['id']}', '{$user['name']}', '{$user['learn']}', '{$user['sex']}', '{$user['credit']}', '{$user['mp']}', '{$user['desc']}', '{$user['follows']}', '{$user['fans']}', '". count($user['course']) ."')";
        $this->db->exec($userSQL);

        // 用户课程信息
        foreach($user['course'] as $key => $value) {
            $courseSQL = "INSERT INTO courses (userid, name, plan, time) VALUES ('{$user['id']}', '{$value['name']}', '{$value['plan']}', '{$value['time']}')";
            $this->db->exec($courseSQL);
        }

    }

    public function getAll() {
        for($i=2000000; $i<2001000; $i++) {
            $result = $this->crawlUserInfo($i);
            if($result !== false) {
                $this->insertDB($result);
            }
        }
    }

    public function get() {

    }

    /**
     * 获取指定用户基本信息和课程信息
     * @param  integer $id 用户ID
     * @return json     
     */
    public function crawlUserInfo($id) {
        // 生成url和cURL请求
        $url = str_replace('{id}', $id, $this->url);
        $output = $this->curlInit($url);

        // 用户合法性检测
        $checkPattern = "/<p>Sorry，找不到你想要的页面<\/p>/";
        if(preg_match($checkPattern, $output) == 1) {
            return false;
        }

        // 获取用户数据
        $user['id'] = $id;
        $user = array_merge($user, $this->dataHandle($output));
        $user['course'] = $this->crawlUserCourse($id);
        
        return $user;
    }

    /**
     * 正则获取并处理用户基本信息
     * @param  string $output
     * @return array
     */
    private function dataHandle($output) {

        $user = [];

        // 匹配用户名
        $namePattern = "/<h3\s+?class=['|\"]user-name\s+?clearfix['|\"]>\s+?<span>(.*?)<\/span>/";
        $user['name'] = $this->matchInfo($namePattern, $output);

        // 匹配学习时长
        $learnPattern = "/<span\s+?class=['|\"]u-info-learn['|\"]>\s+学习时长\s+<em>(.*?)<\/em>\s+<\/span>/";
        $learn = $this->matchInfo($learnPattern, $output);
        $learn = rtrim($learn, '分');
        if(strpos($learn, '小时') !== false) {
            $learn = str_replace('小时', '.', $learn);
        } else {
            $learn = '0.' . $learn;
        }
        $user['learn'] = $learn;

        // 匹配性别
        // $sexPattern = "/<span\s+?class=['|\"]\s?[sexSecret|gender]\s?['|\"]\s+?title=['|\"](.*?)['|\"]><\/span>/";
        $user['sex'] = '未知';

        // 匹配积分
        $creditPattern = "/积分<em>(.*?)<\/em>/";
        $user['credit'] = $this->matchInfo($creditPattern, $output);

        // 匹配经验
        $mpPattern = "/经验<em>(.*?)<\/em>/";
        $user['mp'] = $this->matchInfo($mpPattern, $output);

        // 匹配个性签名
        $descPattern = "/<p\s+?class=['|\"]user-desc['|\"]>(.*?)<\/p>/";
        $user['desc'] = $this->matchInfo($descPattern, $output);

        // 匹配关注
        $followsPattern = "/<em>(.*?)<\/em><\/a>\s+?<span>关注/";
        $user['follows'] = $this->matchInfo($followsPattern, $output);

        // 匹配粉丝
        $fansPattern = "/<em>(.*?)<\/em><\/a>\s+?<span>粉丝/";
        $user['fans'] = $this->matchInfo($fansPattern, $output);

        return $user;
    }

    /**
     * 获取全部课程信息
     * @param  string  $id   要获取的用户id
     * @param  integer $page 要获取的页数，默认1
     * @return array         要返回的课程数组
     */
    public function crawlUserCourse($id, $page=1) {

        // 生成要抓取的URL
        $url = str_replace('{id}', $id, $this->url);

        // 执行抓取
        $output = $this->curlInit($url . "?page={$page}");

        if($page == 1) {
            // 获取用户基本信息
            $user['id'] = $id;
            $user = array_merge($user, $this->dataHandle($output));
            // $user['course'] = $this->crawlUserCourse($id);
        }

        // 匹配课程
        $coursePattern = "/<h3 class=['|\"]study-hd['|\"]>\s+?<a.*?>(.*?)<\/a>[\s\S]*?已学(.*?)<\/span>[\s\S]*?用时(.*?)<\/span>/";
        preg_match_all($coursePattern, $output, $couseArr);

        // 数据处理
        for($i=0; $i<count($couseArr[1]); $i++) {
            $time = rtrim($couseArr[3][$i], '分');
            if(strpos($couseArr[3][$i], '小时') !== false) {
                    $time = str_replace('小时', '.', $time);
                } else {
                    $time = '0.' . $time;
            }
            $user['course'][] = [
                'name'  =>  $couseArr[1][$i],
                'plan'  =>  rtrim($couseArr[2][$i], '%'),
                'time'  =>  $time,
            ];
        }

        // 存在下一页，递归获取
        if(count($couseArr[1]) == 20) {
            // 最后一页是20个课程的特殊情况
            if(count($user['course']) != 20 && $user['course'][count($user['course'])-1] == $user['course'][count($user['course'])-1-20]) {
                return;
            }
            $user['course'] = array_merge($user['course'], $this->crawlUserCourse($id, $page+1));
        }

        return $user;
    }

    /**
     * 执行正则匹配并返回获取到的信息
     * @param  string  $pattern
     * @param  string  $data
     * @param  integer $offset  匹配数据位置，等于0则返回全部结果
     * @return string
     */
    private function matchInfo($pattern, $data, $offset=1) {
        preg_match($pattern, $data, $result);
        return $offset!=0 ? $result[$offset] : $result;
    }
}


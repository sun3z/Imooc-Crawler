<?php 
namespace App\Database;

use App\Config\DBConfig;

class MySQLDB
{
    private static $instance = null;

    /**
     * 单例模式，获取数据库操作类
     * 
     * @return MySQLDB 
     */
    public function getInstanceDB()
    {

        if(is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * 构造方法，初始化PDO数据库操作类
     */
    private function __construct()
    {

        $config = DBConfig::getConfig();
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";

        try {
            $this->instance = new \PDO($dsn, $config['user'], $config['pass']);
        } catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * 将获取到的用户数据插入到数据库中
     * 
     * @param  array $userArr
     */
    public function insertAll($userArr)
    {
        $this->insertUserInfo($userArr);
        $this->insertUserCourses($userArr);
    }

    /**
     * 将用户个人信息数据插入到数据库
     * 
     * @param  array $userArr
     */
    private function insertUserInfo($userArr)
    {   
        $prepareSQL = "INSERT INTO user (moocid, name, learn, sex, job, credit, mp, description, follows, fans, courses) VALUES (:moocid, :name, :learn, :sex, :job, :credit, :mp, :desc, :follows, :fans, :coursesNum)";

        try {

            $stmt = $this->instance->prepare($prepareSQL);

            $stmt->bindParam(':moocid', $userArr['moocid']);
            $stmt->bindParam(':name', $userArr['name']);
            $stmt->bindParam(':learn', $userArr['learn']);
            $stmt->bindParam(':sex', $userArr['sex']);
            $stmt->bindParam(':job', $userArr['job']);
            $stmt->bindParam(':credit', $userArr['credit']);
            $stmt->bindParam(':mp', $userArr['mp']);
            $stmt->bindParam(':desc', $userArr['desc']);
            $stmt->bindParam(':follows', $userArr['follows']);
            $stmt->bindParam(':fans', $userArr['fans']);
            $stmt->bindParam(':coursesNum', $userArr['coursesNum']);

            $stmt->execute();
        } catch(\PdoException $e) {
            die($e->getMessage());
        }
    }

    /**
     * 将用户课程信息数据插入到数据库
     * 
     * @param  array $userArr
     */
    private function insertUserCourses($userArr)
    {
        $prepareSQL = "INSERT INTO courses (userid, name, plan, time) VALUES (:moocid, :name, :plan, :time)";

        try {

            $stmt = $this->instance->prepare($prepareSQL);
            
            for($i=0; $i<count($userArr['courses']); $i++) {
                $stmt->bindParam(':moocid', $userArr['moocid']);
                $stmt->bindParam(':name', $userArr['courses'][$i]['name']);
                $stmt->bindParam(':plan', $userArr['courses'][$i]['plan']);
                $stmt->bindParam(':time', $userArr['courses'][$i]['time']);
                
                $stmt->execute();
            }
        } catch(\PdoException $e) {
            die($e->getMessage());
        }
    }
}

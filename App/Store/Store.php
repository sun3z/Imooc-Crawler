<?php 
namespace App\Store;

use App\Factory\Boot;

class Store
{  
    protected $db = null;

    public function __construct()
    {
        $this->db = Boot::DB();
    }

    public function insertUserInfo($user)
    {
        $sql = "INSERT INTO user (moocid, name, learn, sex, credit, mp, description, follows, fans, courses) VALUES ('{$user['id']}', '{$user['name']}', '{$user['learn']}', '{$user['sex']}', '{$user['credit']}', '{$user['mp']}', '{$user['desc']}', '{$user['follows']}', '{$user['fans']}', '{$user['coursesNum']}')";
        $this->db->exec($sql);
    }

    public function insertUserCourses($user)
    {
        $sql = "INSERT INTO courses (userid, name, plan, time) VALUES ('{$user['id']}', '{$value['name']}', '{$value['plan']}', '{$value['time']}')";
        $this->db->exec($sql);
    }

}

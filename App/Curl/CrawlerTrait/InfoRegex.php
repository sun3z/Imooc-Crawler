<?php 
namespace App\Curl\CrawlerTrait;

trait InfoRegex
{
    protected $pattern = [
        // 404 
        'check' => "/<p>Sorry，找不到你想要的页面<\/p>/",
    
        // 用户名
        'name'      =>  "/<h3\s+?class=['|\"]user-name\s+?clearfix['|\"]>\s+?<span>(.*?)<\/span>/",

        // 学习时长
        'learn'     =>  "/<span\s+?class=['|\"]u-info-learn['|\"]>\s+学习时长\s+<em>(.*?)<\/em>\s+<\/span>/",

        // 匹配性别和职位
        'sexAndJob'       => "/<span\s+class=['|\"].*?[sexSecret|gender].*?['|\"]\s+title=['|\"](.*?)['|\"]><\/span>([\s\S]+?)<span/",

        // 匹配积分
        'credit'    =>  "/积分<em>(.*?)<\/em>/",

        // 匹配经验
        'mp'        =>  "/经验<em>(.*?)<\/em>/",

        // 匹配个性签名
        'desc'      => "/<p\s+?class=['|\"]user-desc['|\"].*?>(.*?)<\/p>/",

        // 匹配关注
        'follows'   => "/<em>(.*?)<\/em><\/a>\s+?<span>关注/",

        // 匹配粉丝
        'fans'      => "/<em>(.*?)<\/em><\/a>\s+?<span>粉丝/",
    ];

}


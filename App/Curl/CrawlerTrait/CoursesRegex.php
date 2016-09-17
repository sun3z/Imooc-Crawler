<?php 
namespace App\Curl\CrawlerTrait;

trait CoursesRegex
{
    public $pattern = [
        'courses'   =>  "/<h3 class=['|\"]study-hd['|\"]>\s+?<a.*?>(.*?)<\/a>[\s\S]*?已学(.*?)<\/span>[\s\S]*?用时(.*?)<\/span>/",
        'hasNext'   =>  "/<span\s+?class=['|\"]disabled_page['|\"]>下一页<\/span>/",
        'hasNext20' =>  "/<div\s+?class=['|\"]qa-comment-page['|\"]>([\s\S]*?)<\/div>/",
    ];
}


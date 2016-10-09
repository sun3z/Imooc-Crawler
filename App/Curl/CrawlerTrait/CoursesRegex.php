<?php 
namespace App\Curl\CrawlerTrait;

trait CoursesRegex
{
    protected $pattern = [
        'courses'   =>  "/<h3 class=['|\"]study-hd['|\"]>\s+?<a.*?>(.*?)<\/a>[\s\S]*?已学(.*?)<\/span>[\s\S]*?用时(.*?)<\/span>/",
        'hasNext'   =>  "/<a href=\"\/u\/\d+\/courses\?page=\d+\">下一页<\/a>/",
        'hasNext20' =>  "/<div\s+?class=['|\"]qa-comment-page['|\"]>([\s\S]*?)<\/div>/",
    ];
}


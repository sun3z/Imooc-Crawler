<?php 
    
require './ImoocSpider.class.php';

$m = new ImoocSpider();

// $m->getAll();
$r = $m->crawlUserCourse(2469898);
var_dump($r);

$("body").append("Some appended text.");
<?php 
namespace App;

use App\Factory\Boot;

class Run
{
    public function __construct()
    {
        $main = Boot::CrawlerController();
        // $main->getOne(2000142);
        $main->getAll(2054250, 3000000);
    }
}

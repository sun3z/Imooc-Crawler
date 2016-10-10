<?php 
namespace App;

use App\Factory\Boot;
use App\Curl\CrawlerQL;

class Run
{
    public function __construct()
    {
        // $main = Boot::CrawlerController();

        // $main->getAll();
        
        new CrawlerQL();

    }
}

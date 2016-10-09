<?php 
namespace App;

use App\Factory\Boot;

class Run
{
    public function __construct()
    {
        $main = Boot::CrawlerController();

        // $main->getOne(2221224);

        $main->getAll();
    }
}

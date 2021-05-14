<?php

namespace App\Console\Commands;

use App\Models\Category;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;

class AddCategoryClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:add-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create subject in Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {

            $url = "https://khoahoc.vietjack.com/trac-nghiem";
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $crawler->filter('div.col-sm-6 > div.info-box')->each(
                function (Crawler $node) use (&$client) {
                    $url = $node->filter('a')->attr('href');
                    $crawler2 = $client->request('GET', $url);
                    $crawler2->filter('a.subject-item')->each(
                        function (Crawler $node2) {
                            $link =  $node2->attr('href');
                            $str = explode('/', $link);
                            $type = $str[count($str) - 1];
                            $name = $node2->filter('a > span.item-wrapper > span')->text();
                            if (Category::where('name', $name)->count() == 0) {
                                $Category = new Category;
                                $Category->name = $name;
                                $Category->type = $type;
                                $Category->save();
                            }
                        }
                    );
                }
            );
            Artisan::call('scout:import',[
                "model" => "\App\\Models\\Category"
            ]);
        });
    }
}

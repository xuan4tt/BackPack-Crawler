<?php

namespace App\Console\Commands;

use App\Models\Class_rom;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClassCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:add-class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create class in Dabatabse';

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
        $url = "https://khoahoc.vietjack.com/trac-nghiem";
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter('div.col-sm-6 > div.info-box')->each(
            function (Crawler $node) {
                $name = $node->filter('a > div.info-box-content > span.info-box-text')->html();
                $url = $node->filter('a')->attr('href');
                if (Class_rom::where('name', $name)->count() == 0) {
                    $Class_rom = new Class_rom;
                    $Class_rom->name = $name;
                    $Class_rom->url = $url;
                    $Class_rom->save();
                }
            }
        );
        Artisan::call('scout:import',[
            "model" => "\App\\Models\\Class_rom"
        ]);
    }
}

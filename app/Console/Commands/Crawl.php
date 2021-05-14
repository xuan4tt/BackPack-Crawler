<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Url_exam_question;
use App\Services\UrlExamService;
use Spatie\Browsershot\Browsershot;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:crawl {link} {category_id} {class_id} {url_id}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $UrlExamService;

    public function __construct(UrlExamService $UrlExamService)
    {
        parent::__construct();
        $this->UrlExamService = $UrlExamService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {
            $link = $this->argument('link');
            $url_exam_question_id = $this->argument('url_id');
            $category_id = $this->argument('category_id');
            $class_id = $this->argument('class_id');

            $url_exam_question = Url_exam_question::find($url_exam_question_id);
            $url_exam_question->status = 1;
            $url_exam_question->save();

            $this->UrlExamService->CrawlData($class_id, $category_id, $url_exam_question_id, $link);
            $link_array = $this->UrlExamService->GetLinkInPage($link);
            foreach ($link_array as $item) {
                $this->UrlExamService->CrawlData($class_id, $category_id, $url_exam_question_id, $item);
            }
        });
        
        Artisan::call('scout:import', [
            "model" => "\App\\Models\\Question"
        ]);
        Artisan::call('scout:import', [
            "model" => "\App\\Models\\Answer"
        ]);
        Artisan::call('scout:import', [
            "model" => "\App\\Models\\Url_exam_question"
        ]);
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\UrlExamQuestionsJob;
use App\Models\Url_exam_question;
use App\Services\UrlExamService;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UrlExamQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:url-exam {url} {class_id} {category_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Url exam question';

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
            $url = $this->argument('url');
            $class_id = $this->argument('class_id');
            $category_id = $this->argument('category_id');
            
            $this->UrlExamService->LinkCrawl($url, $category_id, $class_id);

            //PAGE LINK
            $client = new Client();
            $crawler = $client->request('GET', $url);
            if ($crawler->filter('li.exam-item > div.block-content-exam-item')->count() > 0) {
                if ($crawler->filter('li.page-item > a')->count() > 0) {
                    $crawler->filter('li.page-item > a')->each(function (Crawler $node) use (&$class_id, &$category_id) {
                        $url_page =  $node->attr('href');
                        if ($url_page !== null) {
                            $this->UrlExamService->LinkCrawl($url_page, $category_id, $class_id);
                        }
                    });
                }
            }
        });
    }
}

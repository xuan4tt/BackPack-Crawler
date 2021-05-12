<?php

namespace App\Jobs;

use App\Models\Answer;
use App\Models\Crawling;
use App\Models\Question;

use Goutte\Client;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Polyfill\Intl\Idn\Info;
use Throwable;

class CrawlingJob2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $id)
    {
        $this->url = $url;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $id = $this->id;
        $url = $this->url;
        Log::info("Ha ha ta bat dau job2");
        Artisan::call('VietJack:CrawlJobData', ['id'=>$id, 'url'=>$url]);
        // Redis::throttle('any_key')->allow(2)->every(1)->then(function () {
        //     try {
        //         $link = $this->url;
        //         if (count(Question::where('link', $link)->get()) == 0) {
        //             $crawling = Crawling::find($this->id);
        //             $url_crawler = Browsershot::url($this->url)->bodyHtml();
        //             $crawler = new Crawler($url_crawler);

        //             if ($crawler->filter('div.qas > div.quiz-answer-item')->count() !== 0) {
        //                 //Crawl data
        //                 $crawler->filter('div.qas > div.quiz-answer-item')->each(
        //                     function (Crawler $node) use (&$crawling, &$link) {
        //                         // Question
        //                         $question_content = $node->filter('a.question')->html();
        //                         $question_correct_answer = $node->filter('div.reason')->html();
        //                         // Create data to table Question in DB
        //                         $Question = new Question;
        //                         $Question->class_id = $crawling->class_id;
        //                         $Question->category_id = $crawling->category_id;
        //                         $Question->link = $link;
        //                         $Question->content = $question_content;
        //                         $Question->correct_answer = $question_correct_answer;
        //                         $Question->save();

        //                         // Answer
        //                         $node->filter('div.answer-check > label')->each(function (Crawler $node2) {
        //                             $question_id = Question::orderByDesc('id')->first()->id;
        //                             $answer_content = $node2->filter('p')->html();
        //                             // Create data to table Answer
        //                             $Answer = new Answer;
        //                             $Answer->question_id = $question_id;
        //                             $Answer->content = $answer_content;
        //                             $Answer->save();
        //                         });
        //                     }
        //                 );
        //                 //End crawl data
        //             }
        //         }
        //         //URL CAC DE THI
        //         // if ($crawler->filter('div.quiz-answer-item > ul.exam-related > li')->count() !== 0) {
        //         //     $crawler->filter('div.quiz-answer-item > ul.exam-related > li')->each(
        //         //         function (Crawler $node) use (&$id) {
        //         //             $node_url = $node->filter('a')->attr('href');
        //         //if (count(Question::where('link', $link)->get()) == 0) {
        //         //CrawlingJob3::dispatch($node_url, $id);
        //         //}
        //         //             CrawlingJob2::dispatch($node_url, $id);
        //         //         }
        //         //     );
        //         // }
        //     } catch (Throwable $e) {
        //         Log::info($e);
        //     }
        // }, function () {
        //     return $this->release(2);
        // });
    }
}

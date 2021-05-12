<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Url_exam_question;

use Spatie\Browsershot\Browsershot;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Console\Command;
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
    //protected $UrlExamService;

    public function __construct()
    {
        parent::__construct();
        // $this->UrlExamService = $UrlExamService;
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
            
            $url_crawler = Browsershot::url($link)->bodyHtml();
            $crawler = new Crawler($url_crawler);
            if ($crawler->filter('div.qas > div.quiz-answer-item')->count() !== 0) {
                //Crawl data
                $crawler->filter('div.qas > div.quiz-answer-item')->each(
                    function (Crawler $node) use (&$category_id, &$class_id, &$url_exam_question_id, &$link) {
                        // Question
                        $question_content = $node->filter('a.question')->html();
                        $question_correct_answer = $node->filter('div.reason')->html();
                        // Create data to table Question in DB
                        $Question = new Question();
                        $Question->class_id = $class_id;
                        $Question->category_id = $category_id;
                        $Question->url_exam_question_id = $url_exam_question_id;
                        $Question->content = $question_content;
                        $Question->correct_answer = $question_correct_answer;
                        $Question->link = $link;
                        $Question->save();

                        // Answer
                        $node->filter('div.answer-check > label')->each(function (Crawler $node2) {
                            $question_id = Question::orderByDesc('id')->first()->id;
                            $answer_content = $node2->filter('p')->html();
                            // Create data to table Answer
                            $Answer = new Answer();
                            $Answer->question_id = $question_id;
                            $Answer->content = $answer_content;
                            $Answer->save();
                        });
                    }
                );
                //End crawl data
            }
        });
    }
}

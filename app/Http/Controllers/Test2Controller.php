<?php

namespace App\Http\Controllers;

use App\Jobs\CreateIndexJob;
use App\Models\Answer;
use App\Models\Class_rom;
use App\Models\Question;
use App\Models\Test;
use App\Models\Url_exam_question;
use App\QuestionSearch;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Goutte\Client;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\DomCrawler\Crawler;

class Test2Controller extends Controller
{
    public function index()
    {   
        $link = 'https://khoahoc.vietjack.com/thi-online/30-de-thi-thu-thpt-quoc-gia-mon-toan-co-loi-giai-chi-tiet-moi-nhat/24974';
        $url_crawler = Browsershot::url($link)->bodyHtml();
        $crawler = new Crawler($url_crawler);
        if ($crawler->filter('div.qas > div.quiz-answer-item')->count() !== 0) {
            //Crawl data
            $crawler->filter('div.qas > div.quiz-answer-item')->each(
                function (Crawler $node) use (&$category_id, &$class_id, &$url_exam_question_id, &$link) {

                    // Question
                    $question_content = $node->filter('a.question > p')->eq(1)->html();
                    dd($question_content);
                    $question_correct_answer = $node->filter('div.reason')->html();
                    


                }
            );
            //End crawl data
        }
    }

    public function check(Request $request)
    {
        $request = request()->all();
        $search = $request['search'];
        // $x = Question::search($search)
        //     ->rule(QuestionSearch::class)->first();

        $x = Question::searchRaw([

            "query" => [
                "match" => ["content" => $search]
            ],

            "highlight" => [

                // "order"=> "score",
                // "require_field_match"=> true,
                "fields" => [
                    "content" => [
                        "pre_tags" => ["<b>"],
                        "post_tags" => ["</b>"],
                        "number_of_fragments" => 0
                        //"boundary_max_scan" => 10

                    ]
                ]
            ]
        ]);

        //  
        $data = $x['hits']['hits'];
        // $a = Question::search($search)->raw()['hits'];
        // dd(collect($a['hits'])->pluck('_source'));
        return view('test2', compact('data'));
    }
}

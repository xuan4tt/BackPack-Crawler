<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Url_exam_question;

use Spatie\Browsershot\Browsershot;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class UrlExamService
{
    public function LinkCrawl($url, $category_id, $class_id)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        if ($crawler->filter('li.exam-item > div.block-content-exam-item')->count() > 0) {
            $crawler->filter('li.exam-item > div.block-content-exam-item')->each(function (Crawler $node) use (&$class_id, &$category_id) {
                $link = $node->filter('a.url-root')->attr('href');
                $client = new Client();
                $crawler = $client->request('GET', $link);
                if ($crawler->filter('div.qas > div.quiz-answer-item')->count() > 0) {
                    $name =  $node->filter('a.url-root')->text();
                    if (Url_exam_question::where('link', $link)->count() == 0) {
                        $url_exam_question = new Url_exam_question();
                        $url_exam_question->class_id = $class_id;
                        $url_exam_question->category_id = $category_id;
                        $url_exam_question->name = $name;
                        $url_exam_question->link = $link;
                        $url_exam_question->save();
                    }
                }
            });
        }
    }

    public function CrawlData($class_id, $category_id, $url_exam_question_id, $link)
    {
        $url_crawler = Browsershot::url($link)->bodyHtml();
        $crawler = new Crawler($url_crawler);
        if ($crawler->filter('div.qas > div.quiz-answer-item')->count() !== 0) {
            //Crawl data
            $crawler->filter('div.qas > div.quiz-answer-item')->each(
                function (Crawler $node) use (&$category_id, &$class_id, &$url_exam_question_id, &$link) {

                    // Question
                    $question_content = $node->filter('a.question > p')->eq(1)->html();
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
                    $question_id = $Question->id;

                    // Answer
                    $node->filter('div.answer-check > label')->each(function (Crawler $node2) use (&$question_id) {
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
    }

    public function GetLinkInPage($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $url_arr = [];
        if ($crawler->filter('div.quiz-answer-item > ul.exam-related > li')->count() !== 0) {
            $crawler->filter('div.quiz-answer-item > ul.exam-related > li')->each(
                function (Crawler $node) use (&$url_arr) {
                    $node_url = $node->filter('a')->attr('href');
                    $client = new Client();
                    $crawler = $client->request('GET', $node_url);
                    if ($crawler->filter('div.qas > div.quiz-answer-item')->count() !== 0) {
                        array_push($url_arr, $node_url);
                    }
                }
            );
        }
        return $url_arr;
    }
}

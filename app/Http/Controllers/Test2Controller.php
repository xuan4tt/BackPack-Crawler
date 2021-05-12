<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Url_exam_question;
use App\QuestionSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use Goutte\Client;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Support\Facades\Redis;

class Test2Controller extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function check(Request $request)
    {
        $request = request()->all();
        $search = $request['search'];
        // $x = Question::search('content')
        //     ->rule(function ($search) {
        //         $request = request()->all();
        //         $search = $request['search'];
        //         return [
        //             'must' => [
        //                 'query_string' => [
        //                     'query' => $search
        //                 ]
        //             ]
        //         ];
        //     })
        //     ->get();
        //dd($x);>
        $x = Question::search($search)
            ->rule(QuestionSearch::class)->explain();
        //dd($x['hits']['hits']);
        // foreach($x['hits']['hits'] as $item ){
        //     dd($item['_score'], $item['_source']['content']);
        // }
        $xx = $x['hits']['hits'];
        //return view(backpack_view('dashboard'));
        return view('test2', compact('xx'));
    }
}

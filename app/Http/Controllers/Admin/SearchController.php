<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\QuestionSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }
    public function getdata(Request $request)
    {
        $search = $request->all()['search'];
        $data = Question::searchRaw
        ([
            "query" => [
                "match" => ["content" => $search]
            ],
            "size" => 1,
            "highlight" => [
                "fields" => [
                    "content" => [
                        "pre_tags" => ["<span style='background-color:#ffbf00;color:#fff;'><b>"],
                        "post_tags" => ["</b></span>"],
                        "number_of_fragments" => 0
                        //"boundary_max_scan" => 10
                    ]
                ]
            ]
        ]);
        $data_search = $data['hits']['hits'];
        return $data_search;
    }
}

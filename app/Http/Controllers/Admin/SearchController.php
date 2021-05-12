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
        return view(backpack_view('search'));
    }
    public function getdata(Request $request)
    {
        $search = $request->all()['search'];
        $data = Question::search($search)
            ->rule(QuestionSearch::class)->explain();
        $data_search = $data['hits']['hits'];
        return $data_search;
    }
}

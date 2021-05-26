<?php

namespace App\Http\Controllers;

use App\Events\TestEnvent;
use App\Models\Test;
use App\Notifications\TestNotification;
use App\Models\User;
use Pusher\Pusher;
use Illuminate\Http\Request;


class Test2Controller extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function kiemtra()
    {
        return view('test2');
    }
    //    public function test(Request  $request){
    ////        $user = User::find(1);
    ////        $post = Test::create([
    ////            'test' => 1
    ////        ]);
    ////
    ////       trigger('NotificationEvent', 'send-message', $post);
    ////        return view('notification');
    //        event(new TestEnvent($request->get('message')));
    //        return [
    //            'status' => true,
    //        ];
    //    }
    //    public function check(Request $request)
    //    {
    //        $request = request()->all();
    //        $search = $request['search'];
    //        // $x = Question::search($search)
    //        //     ->rule(QuestionSearch::class)->first();
    //
    //        $x = Question::searchRaw([
    //
    //            "query" => [
    //                "match" => ["content" => $search]
    //            ],
    //
    //            "highlight" => [
    //
    //                // "order"=> "score",
    //                // "require_field_match"=> true,
    //                "fields" => [
    //                    "content" => [
    //                        "pre_tags" => ["<b>"],
    //                        "post_tags" => ["</b>"],
    //                        "number_of_fragments" => 0
    //                        //"boundary_max_scan" => 10
    //
    //                    ]
    //                ]
    //            ]
    //        ]);
    //
    //        //
    //        $data = $x['hits']['hits'];
    //        // $a = Question::search($search)->raw()['hits'];
    //        // dd(collect($a['hits'])->pluck('_source'));
    //        return view('test2', compact('data'));
    //    }
}

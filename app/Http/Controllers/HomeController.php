<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Class_rom;
use App\Models\Question;
use App\Models\Select2;
use App\Models\Url_exam_question;
use Illuminate\Http\Request;
use App\Events\ServerCreated;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){

        // Auth::logout();
        return view('index');
    }

    public function class(){
        $class = Class_rom::all();
        return view('class', compact('class'));
    }

    public function exams($class_id){
        return view('exams', compact('class_id'));
    }

    public function exam_detail($url_id){
        $exam = Url_exam_question::find($url_id);
        return view('exam_detail', compact('exam'));
    }

    public function doing($exam){
        Select2::where('id', '>', 0)->delete();
        return view('doing', compact('exam'));
    }

    public function finish($exam){

        $select = Select2::all();
        $correct = 0;
        foreach($select as $item){
            $question = Question::find($item->question_id);
            $aswer = Answer::find($item->answer_id);
            if(strlen(strstr(strip_tags($question->correct_answer), substr(strip_tags($aswer->content),0,1)))>0 && strlen(strstr(strip_tags($question->correct_answer), substr(strip_tags($aswer->content),0,1))) < 5){
                $correct++;
            }
        }
        dd($correct);
        return view('finish');
    }

    public function form(){
        return view('form');
    }

    public function PostForm(Request $request)
    {
        $request = $request->all();
        $user = \App\Models\User::where('email', $request['email'])->first();
        if($user){
            $data = [
                'user_id_send' => Auth::user()->id,
                'email' => Auth::user()->email,
                'title' => $request['title'],
                'content' => $request['content'],
                'user_id' => $user->id,

            ];
            broadcast(new ServerCreated($data));
        }

        return redirect()->back();
    }

}

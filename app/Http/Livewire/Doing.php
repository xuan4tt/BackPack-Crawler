<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\Select2;
use DOMDocument;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Livewire\WithPagination;

class Doing extends Component
{
    use WithPagination;



    protected $listeners = [
        'Click' => 'Test',
    ];



    public $exam;



    public function Test($answer_id, $question_id)
    {
        $select = new Select2;
        $select2 = Select2::where('question_id', $question_id)->first();
        if (isset($select2)) {
           $update_select = Select2::find($select2->id);
           $update_select->answer_id = $answer_id;
           $update_select->save();
        } else {
            $select->answer_id = $answer_id;
            $select->question_id = $question_id;
            $select->save();
        }
    }

    public function render()
    {

        $url_exam_id = $this->exam;
        $questions = Question::where('url_exam_question_id', $url_exam_id)->paginate(1);
        $select = Select2::where('question_id', $questions[0]->id)->first();
        //dd($questions[0]->id, $select);
        return view('livewire.doing', [
            'questions' => $questions,
            'select' => $select,
            'url_exam_id' => $url_exam_id
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Class_rom;
use App\Models\Url_exam_question;
use Livewire\Component;
use Livewire\WithPagination;

class Test extends Component
{
    use WithPagination;

    public $class_id;

    // public function ClickSubject($id){
    //     dd($id);
    // }

    public function render()
    {
        $class_id = $this->class_id;
        $class = Class_rom::find($class_id);
        $question = Url_exam_question::where('class_id', $class_id)->where('status', 1);
        $subject = $question->get()->groupBy('category_id');
        if (isset($_GET['subject'])) {
            $category_id = $_GET['subject'];
        } else {
            $category_id = $subject->first()[0]->category->id;
        }
        $exams = $question->where('category_id', $category_id)->paginate(6);
        return view('livewire.test', [
            'exams' => $exams,
            'class' => $class,
            'subject' => $subject,
            'category_id' => $category_id
        ]);
    }
}

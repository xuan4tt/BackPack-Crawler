<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Select2 extends Model
{
    use HasFactory;

    protected $table = "select2";

    public function answer(){
        return $this->belongsTo(Answer::class, 'answer_id', 'id');
    }

    public function question(){
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}

<?php

namespace App\Models;

use App\QuestionConfigurator;
use App\QuestionSearch;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use CrudTrait;
    use Searchable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'questions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $indexConfigurator = QuestionConfigurator::class;

    protected $searchRules = [
        QuestionSearch::class
    ];
    protected $mapping = [
        'properties' => [
            'content' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ]
                ]
            ]
        ]
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function QuestionCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function QuestionClass_rom()
    {
        return $this->belongsTo(Class_rom::class, 'class_id', 'id');
    }

    public function QuestionUrl_exam_question()
    {
        return $this->belongsTo(Url_exam_question::class, 'url_exam_question_id', 'id');
    }
}

<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Crawling extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'crawling';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

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
    public function CrawlingCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function CrawlingUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function CrawlingQuestion()
    {
        return $this->hasMany(Question::class, 'question_id', 'id');
    }

    public function CrawlingClass_rom()
    {
        return $this->belongsTo(Class_rom::class, 'class_id', 'id');
    }

    public function ActionCrawling($crud = false)
    {
        return '<a class="btn btn-primary"  href="crawling/'.urlencode($this->id).'/action_crawling" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Crawl link</a>';
    }
}

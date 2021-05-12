<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('crawling', 'CrawlingCrudController');
    Route::get('crawling/{id}/action_crawling', 'CrawlingCrudController@crawling');
    Route::crud('question', 'QuestionCrudController');
    Route::crud('answer', 'AnswerCrudController');
    Route::crud('correct_answer', 'Correct_answerCrudController');
    
    Route::crud('class_rom', 'Class_romCrudController');
    Route::crud('url_exam_question', 'Url_exam_questionCrudController');

    Route::get('search', 'SearchController@index')->name('search.index');
    Route::post('post/search', 'SearchController@getdata')->name('search.getdata');
}); // this should be the absolute last line of this file
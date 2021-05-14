<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class CreateIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('elastic:create-index',[
            'index-configurator' => 'App\AnswerConfigurator'
        ]);
        Artisan::call('elastic:create-index',[
            'index-configurator' => 'App\CategoryConfigurator'
        ]);
        Artisan::call('elastic:create-index',[
            'index-configurator' => 'App\Class_romConfigurator'
        ]);
        Artisan::call('elastic:create-index',[
            'index-configurator' => 'App\QuestionConfigurator'
        ]);
        Artisan::call('elastic:create-index',[
            'index-configurator' => 'App\Url_exam_questionConfigurator'
        ]);
        
        
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class UrlExamQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $url;
    protected $class_id;
    protected $category_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $class_id, $category_id)
    {
        $this->url = $url;
        $this->class_id = $class_id;
        $this->category_id = $category_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        Log::info("UrlExamQuestionJob start");
        $url = $this->url;
        $class_id = $this->class_id;
        $category_id = $this->category_id;
        Artisan::call('vietjack:url-exam', [
            'url'=> $url,
            'class_id' => $class_id,
            'category_id' => $category_id
        ]);
    }
}

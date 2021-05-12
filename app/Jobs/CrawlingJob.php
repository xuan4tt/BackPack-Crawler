<?php

namespace App\Jobs;

use App\Models\Url_exam_question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Throwable;

class CrawlingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $link;
    protected $category_id;
    protected $class_id;
    protected $url_exam_question_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($link, $category_id, $class_id, $url_exam_question_id)
    {
        $this->link = $link;
        $this->category_id = $category_id;
        $this->class_id = $class_id;
        $this->url_exam_question_id = $url_exam_question_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $link = $this->link;
        $category_id = $this->category_id;
        $class_id = $this->class_id;
        $url_exam_question_id = $this->url_exam_question_id;

        Artisan::call('vietjack:crawl', [
            'link' => $link,
            'category_id' => $category_id,
            'class_id' => $class_id,
            'url_id' => $url_exam_question_id
        ]);
    }
}

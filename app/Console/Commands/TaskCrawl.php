<?php

namespace App\Console\Commands;

use App\Jobs\CrawlingJob;
use App\Jobs\TestJob;
use App\Models\Url_exam_question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TaskCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vietjack:task-crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        if (Url_exam_question::where('status', 0)->count() > 0) {
            $link =  Url_exam_question::where('status', 0)->orderBy('class_id', 'ASC')->first();
            $url_exam_question = Url_exam_question::where('link', $link->link)->first();
            CrawlingJob::dispatch($link->link, $link->category_id, $link->class_id, $url_exam_question->id);
        }
    }
}
